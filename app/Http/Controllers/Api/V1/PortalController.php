<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Portal\{Appointment, Committee, Membership, Organisation, Role};
use App\Models\{University, User};
use App\Services\PortalAccess;
use App\Support\PublicContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Support\Str;
use Illuminate\Validation\{Rule, ValidationException};

class PortalController extends Controller
{
    public function __construct(private PortalAccess $access) {}

    private function organisationData(User $user, Organisation $organisation): array
    {
        return $organisation->only(['id', 'name', 'slug', 'kind', 'parent_id', 'active', 'primary_colour', 'secondary_colour']) + [
            'logo_url' => $organisation->logo_path ? PublicContent::image('public/'.$organisation->logo_path) : null,
            'permissions' => $this->access->permissions($user, $organisation),
        ];
    }

    public function me(Request $request): array
    {
        $user = $request->user();
        $organisations = Organisation::whereHas('memberships', fn ($q) => $q->where('user_id', $user->id)->where('active', true))->where('active', true)->orderBy('name')->get();
        $association = Organisation::where('slug', 'bulsca')->firstOrFail();
        return ['data' => [
            'user' => $user->only(['id', 'name', 'email']),
            'organisations' => $organisations->map(fn ($org) => $this->organisationData($user, $org))->values(),
            'association_id' => $association->id,
            'can_administer' => $this->access->root($user) || count($this->access->permissions($user, $association)) > 0,
            'is_superadmin' => $this->access->root($user), 'today' => now('Europe/London')->toDateString(),
        ]];
    }

    public function index(Request $request): array
    {
        $user = $request->user();
        $association = Organisation::where('slug', 'bulsca')->firstOrFail();
        $this->access->authorize($user, $association, 'clubs.manage');
        return ['data' => [
            'organisations' => Organisation::orderBy('name')->get()->map(fn ($org) => $this->organisationData($user, $org)),
            'legacy_clubs' => University::whereNotIn('id', Organisation::whereNotNull('university_id')->select('university_id'))->orderBy('name')->get(['id', 'name']),
        ]];
    }

    public function store(Request $request)
    {
        $association = Organisation::where('slug', 'bulsca')->firstOrFail();
        $this->access->authorize($request->user(), $association, 'clubs.manage');
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'administrator_email' => 'required|email|max:254',
            'university_id' => ['nullable', 'integer', Rule::exists('universities', 'id'), Rule::unique('portal_organisations', 'university_id')],
        ]);
        $administrator = User::whereRaw('LOWER(email) = ?', [strtolower($data['administrator_email'])])->first();
        if (! $administrator) throw ValidationException::withMessages(['administrator_email' => 'Ask this person to sign in through SSO once before adding them.']);
        $organisation = DB::transaction(function () use ($data, $association, $administrator, $request) {
            $organisation = Organisation::create(['name' => $data['name'], 'slug' => (Str::slug($data['name']) ?: 'club').'-'.Str::lower(Str::random(8)), 'kind' => 'club', 'parent_id' => $association->id, 'university_id' => $data['university_id'] ?? null]);
            $membership = Membership::create(['organisation_id' => $organisation->id, 'user_id' => $administrator->id]);
            $committee = Committee::create(['organisation_id' => $organisation->id, 'name' => 'Initial committee', 'starts_on' => now('Europe/London')->toDateString()]);
            $role = $this->access->managerRole($organisation);
            Appointment::create(['organisation_id' => $organisation->id, 'membership_id' => $membership->id, 'committee_id' => $committee->id, 'role_id' => $role->id]);
            $this->access->audit($request->user(), $organisation, 'organisation.created', ['administrator_membership_id' => $membership->id]);
            return $organisation;
        });
        return response()->json(['data' => $this->organisationData($request->user(), $organisation->fresh())], 201);
    }

    public function show(Request $request, Organisation $organisation): array
    {
        $user = $request->user();
        $this->access->authorize($user, $organisation);
        $permissions = $this->access->permissions($user, $organisation);
        $canManage = in_array('members.manage', $permissions, true);
        $request->validate(['q' => 'nullable|string|max:100', 'page' => 'nullable|integer|min:1|max:100000']);
        $members = $organisation->memberships()->with(['user:id,name,email', 'appointments.role', 'appointments.committee'])->orderBy('id');
        if (! $canManage) $members->where('active', true);
        if ($request->filled('q')) $members->whereHas('user', fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'));
        $page = $members->paginate(25);
        $committees = $organisation->committees()->with(['appointments.membership.user:id,name', 'appointments.role'])->orderByDesc('starts_on')->get();
        return ['data' => [
            'organisation' => $this->organisationData($user, $organisation),
            'members' => $page->getCollection()->map(fn ($member) => [
                'id' => $member->id, 'name' => $member->user->name, 'active' => $member->active,
                ...($canManage ? ['email' => $member->user->email] : []),
                'roles' => $member->appointments->filter(fn ($appointment) => ! $appointment->revoked_at && $appointment->committee->starts_on->toDateString() <= now('Europe/London')->toDateString() && (! $appointment->committee->ends_on || $appointment->committee->ends_on->toDateString() >= now('Europe/London')->toDateString()))->map(fn ($appointment) => ['id' => $appointment->role->id, 'name' => $appointment->role->name])->unique('id')->values(),
            ]),
            'pagination' => ['current_page' => $page->currentPage(), 'last_page' => $page->lastPage(), 'total' => $page->total()],
            'committees' => $committees->map(fn ($committee) => [
                'id' => $committee->id, 'name' => $committee->name, 'starts_on' => $committee->starts_on->toDateString(), 'ends_on' => $committee->ends_on?->toDateString(),
                'appointments' => $committee->appointments->map(fn ($appointment) => [
                    'id' => $appointment->id, 'membership_id' => $appointment->membership_id, 'role_id' => $appointment->role_id,
                    'name' => $appointment->membership->user->name, 'role' => $appointment->role->name, 'active' => $appointment->membership->active && ! $appointment->revoked_at,
                ]),
            ]),
            'roles' => $organisation->roles()->orderBy('name')->get()->map(fn ($role) => $role->only(['id', 'name', 'permissions', 'protected'])),
            'permission_catalogue' => $this->access->catalogue($organisation),
            'audit' => count($permissions) ? DB::table('portal_audit_events')->where('organisation_id', $organisation->id)->orderByDesc('id')->limit(20)->get(['id', 'action', 'created_at']) : [],
        ]];
    }

    /** Serialize management writes on the organisation row; enforce permissions again under the lock. */
    private function write(Request $request, Organisation $organisation, string $permission, callable $callback)
    {
        return DB::transaction(function () use ($request, $organisation, $permission, $callback) {
            $locked = Organisation::whereKey($organisation->id)->lockForUpdate()->firstOrFail();
            $this->access->authorize($request->user(), $locked, $permission);
            return $callback($locked);
        });
    }

    public function member(Request $request, Organisation $organisation)
    {
        $this->access->authorize($request->user(), $organisation, 'members.manage');
        $data = $request->validate(['email' => 'required|email|max:254']);
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($data['email'])])->first();
        if (! $user) throw ValidationException::withMessages(['email' => 'Ask this person to sign in through SSO once before adding them.']);
        return $this->write($request, $organisation, 'members.manage', function () use ($request, $organisation, $user) {
            $member = Membership::firstOrCreate(['organisation_id' => $organisation->id, 'user_id' => $user->id]);
            if (! $member->active) throw ValidationException::withMessages(['email' => 'This membership is inactive. Reactivate it explicitly instead.']);
            $this->access->audit($request->user(), $organisation, 'membership.added', ['membership_id' => $member->id]);
            return response()->json(['data' => ['id' => $member->id]], 201);
        });
    }

    public function membership(Request $request, Organisation $organisation, int $membership)
    {
        return $this->write($request, $organisation, 'members.manage', function () use ($request, $organisation, $membership) {
            $member = $organisation->memberships()->findOrFail($membership);
            $data = $request->validate(['active' => 'required|boolean']);
            $member->update($data);
            if (! $data['active']) $member->appointments()->update(['revoked_at' => now()]);
            if (! $data['active']) $this->access->assertManagerRemains($organisation);
            $this->access->audit($request->user(), $organisation, 'membership.updated', ['membership_id' => $member->id, 'active' => $member->active]);
            return response()->json(['data' => ['id' => $member->id]]);
        });
    }

    public function committee(Request $request, Organisation $organisation)
    {
        return $this->write($request, $organisation, 'committees.manage', function () use ($request, $organisation) {
            $data = $request->validate(['name' => 'required|string|max:100', 'starts_on' => 'required|date_format:Y-m-d', 'ends_on' => 'nullable|date_format:Y-m-d|after_or_equal:starts_on']);
            $committee = $organisation->committees()->create($data);
            $this->access->audit($request->user(), $organisation, 'committee.created', ['committee_id' => $committee->id]);
            return response()->json(['data' => ['id' => $committee->id]], 201);
        });
    }

    public function committeeUpdate(Request $request, Organisation $organisation, int $committee)
    {
        return $this->write($request, $organisation, 'committees.manage', function () use ($request, $organisation, $committee) {
            $term = $organisation->committees()->findOrFail($committee);
            $data = $request->validate(['name' => 'required|string|max:100', 'starts_on' => 'required|date_format:Y-m-d', 'ends_on' => 'nullable|date_format:Y-m-d|after_or_equal:starts_on']);
            $term->update($data);
            $this->access->assertManagerRemains($organisation);
            $this->access->audit($request->user(), $organisation, 'committee.updated', ['committee_id' => $term->id]);
            return response()->json(['data' => ['id' => $term->id]]);
        });
    }

    public function role(Request $request, Organisation $organisation, ?int $role = null)
    {
        return $this->write($request, $organisation, 'roles.manage', function () use ($request, $organisation, $role) {
            $existing = $role ? $organisation->roles()->findOrFail($role) : null;
            abort_if($existing?->protected, 403);
            if ($existing) $this->access->delegatable($request->user(), $organisation, $existing->permissions);
            $data = $request->validate([
                'name' => ['required', 'string', 'max:80', Rule::unique('portal_roles', 'name')->where('organisation_id', $organisation->id)->ignore($existing?->id)],
                'permissions' => 'present|array|max:5', 'permissions.*' => ['string', 'distinct', Rule::in(array_keys($this->access->catalogue($organisation)))],
                'protected' => 'prohibited', 'organisation_id' => 'prohibited',
            ]);
            $this->access->delegatable($request->user(), $organisation, $data['permissions']);
            $saved = $existing ?? new Role(['organisation_id' => $organisation->id]);
            $saved->fill($data)->save();
            $this->access->audit($request->user(), $organisation, 'role.saved', ['role_id' => $saved->id, 'permissions' => $saved->permissions]);
            return response()->json(['data' => ['id' => $saved->id]], $existing ? 200 : 201);
        });
    }

    public function appointment(Request $request, Organisation $organisation)
    {
        return $this->write($request, $organisation, 'committees.manage', function () use ($request, $organisation) {
            $data = $request->validate([
                'membership_id' => ['required', 'integer', Rule::exists('portal_memberships', 'id')->where('organisation_id', $organisation->id)->where('active', true)],
                'committee_id' => ['required', 'integer', Rule::exists('portal_committees', 'id')->where('organisation_id', $organisation->id)],
                'role_id' => ['required', 'integer', Rule::exists('portal_roles', 'id')->where('organisation_id', $organisation->id)],
            ]);
            $role = $organisation->roles()->findOrFail($data['role_id']);
            $this->access->delegatable($request->user(), $organisation, $role->permissions);
            $appointment = Appointment::firstOrCreate(['organisation_id' => $organisation->id] + $data);
            if ($appointment->revoked_at) { $appointment->revoked_at = null; $appointment->save(); }
            $this->access->audit($request->user(), $organisation, 'appointment.added', ['appointment_id' => $appointment->id]);
            return response()->json(['data' => ['id' => $appointment->id]], 201);
        });
    }

    public function removeRole(Request $request, Organisation $organisation, int $role)
    {
        return $this->write($request, $organisation, 'roles.manage', function () use ($request, $organisation, $role) {
            $existing = $organisation->roles()->findOrFail($role);
            abort_if($existing->protected, 403);
            $this->access->delegatable($request->user(), $organisation, $existing->permissions);
            if (Appointment::where('role_id', $role)->exists()) throw ValidationException::withMessages(['role' => 'This role has committee history. Edit it or end its appointments instead.']);
            $existing->delete();
            $this->access->audit($request->user(), $organisation, 'role.removed', ['role_id' => $role]);
            return response()->json(['data' => ['removed' => true]]);
        });
    }

    public function removeAppointment(Request $request, Organisation $organisation, int $appointment)
    {
        return $this->write($request, $organisation, 'committees.manage', function () use ($request, $organisation, $appointment) {
            $assignment = Appointment::where('organisation_id', $organisation->id)->findOrFail($appointment);
            $this->access->delegatable($request->user(), $organisation, $assignment->role->permissions);
            $assignment->revoked_at = now();
            $assignment->save();
            $this->access->assertManagerRemains($organisation);
            $this->access->audit($request->user(), $organisation, 'appointment.removed', ['appointment_id' => $appointment]);
            return response()->json(['data' => ['removed' => true]]);
        });
    }

    public function branding(Request $request, Organisation $organisation)
    {
        return $this->write($request, $organisation, 'branding.manage', function () use ($request, $organisation) {
            $data = $request->validate(['primary_colour' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'], 'secondary_colour' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'], 'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048|dimensions:max_width=2048,max_height=2048']);
            $old = $organisation->logo_path;
            unset($data['logo']);
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->storePublicly('portal-logos/'.$organisation->id, 'public');
                if (! $path) throw new \RuntimeException('Logo storage unavailable');
                $data['logo_path'] = $path;
            }
            $organisation->update($data);
            $this->access->audit($request->user(), $organisation, 'branding.updated', ['logo_changed' => isset($data['logo_path'])]);
            // Delete the previous file only after the SQL transaction has committed.
            if (isset($data['logo_path']) && $old) DB::afterCommit(function () use ($old) { try { Storage::disk('public')->delete($old); } catch (\Throwable) {} });
            return response()->json(['data' => $this->organisationData($request->user(), $organisation->fresh())]);
        });
    }
}
