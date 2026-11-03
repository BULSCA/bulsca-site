<?php

namespace App\Services;

use App\Models\Portal\{Committee, Membership, Organisation, Role};
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PortalAccess
{
    public const CLUB = [
        'branding.manage' => 'Edit colours and logo',
        'members.manage' => 'Add and manage members',
        'committees.manage' => 'Create committees and appoint members',
        'roles.manage' => 'Create and manage restricted roles',
    ];
    public const ASSOCIATION = ['clubs.manage' => 'Create and administer affiliated clubs'];

    public function catalogue(Organisation $organisation): array
    {
        return self::CLUB + ($organisation->kind === 'association' ? self::ASSOCIATION : []);
    }

    public function root(User $user): bool { return $user->hasRole('super_admin'); }

    public function directPermissions(User $user, Organisation $organisation): array
    {
        if (! $organisation->active) return [];
        $today = now('Europe/London')->toDateString();
        $rows = DB::table('portal_appointments as a')
            ->join('portal_memberships as m', 'm.id', '=', 'a.membership_id')
            ->join('portal_roles as r', 'r.id', '=', 'a.role_id')
            ->join('portal_committees as c', 'c.id', '=', 'a.committee_id')
            ->where('a.organisation_id', $organisation->id)->whereNull('a.revoked_at')->where('m.user_id', $user->id)->where('m.active', true)
            ->where('c.starts_on', '<=', $today)->where(fn ($q) => $q->whereNull('c.ends_on')->orWhere('c.ends_on', '>=', $today))
            ->pluck('r.permissions');
        return array_values(array_intersect(array_keys($this->catalogue($organisation)), $rows->flatMap(fn ($permissions) => json_decode($permissions, true) ?? [])->unique()->all()));
    }

    public function permissions(User $user, Organisation $organisation): array
    {
        if ($this->root($user)) return array_keys($this->catalogue($organisation));
        if (! $organisation->active) return [];
        if ($organisation->kind === 'club' && $organisation->parent_id) {
            $parent = Organisation::find($organisation->parent_id);
            if ($parent && in_array('clubs.manage', $this->directPermissions($user, $parent), true)) return array_keys(self::CLUB);
        }
        return $this->directPermissions($user, $organisation);
    }

    public function view(User $user, Organisation $organisation): bool
    {
        return $this->root($user) || ($organisation->active && ($organisation->memberships()->where('user_id', $user->id)->where('active', true)->exists() || count($this->permissions($user, $organisation)) > 0));
    }

    public function authorize(User $user, Organisation $organisation, ?string $permission = null): void
    {
        abort_unless($this->view($user, $organisation), 404);
        if ($permission) abort_unless(in_array($permission, $this->permissions($user, $organisation), true), 403);
    }

    public function delegatable(User $user, Organisation $organisation, array $permissions): void
    {
        if (array_diff($permissions, array_keys($this->catalogue($organisation))) || array_diff($permissions, $this->permissions($user, $organisation))) {
            throw ValidationException::withMessages(['permissions' => 'You may only delegate permissions you hold within this organisation.']);
        }
    }

    public function managerRole(Organisation $organisation): Role
    {
        return Role::firstOrCreate(['organisation_id' => $organisation->id, 'name' => 'Organisation manager'], ['permissions' => array_keys($this->catalogue($organisation)), 'protected' => true]);
    }

    public function assertManagerRemains(Organisation $organisation): void
    {
        $today = now('Europe/London')->toDateString();
        $exists = DB::table('portal_appointments as a')->join('portal_roles as r', 'r.id', '=', 'a.role_id')->join('portal_memberships as m', 'm.id', '=', 'a.membership_id')->join('portal_committees as c', 'c.id', '=', 'a.committee_id')
            ->where('a.organisation_id', $organisation->id)->whereNull('a.revoked_at')->where('r.protected', true)->where('m.active', true)->where('c.starts_on', '<=', $today)->where(fn ($q) => $q->whereNull('c.ends_on')->orWhere('c.ends_on', '>=', $today))->exists();
        if (! $exists) throw ValidationException::withMessages(['manager' => 'Appoint another current organisation manager before removing the last one.']);
    }

    public function audit(User $actor, Organisation $organisation, string $action, array $changes): void
    {
        DB::table('portal_audit_events')->insert(['actor_id' => $actor->id, 'organisation_id' => $organisation->id, 'action' => $action, 'changes' => json_encode($changes, JSON_THROW_ON_ERROR), 'created_at' => now()]);
    }
}
