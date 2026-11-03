<?php

namespace Tests\Feature\Api;

use App\Models\Portal\{Appointment, Committee, Membership, Organisation, Role};
use App\Models\User;
use App\Services\PortalAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{DB, Http, Storage};
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    private User $root;
    private User $manager;
    private Organisation $club;
    private Organisation $association;
    private Membership $managerMembership;
    private Committee $committee;
    private Role $managerRole;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now('Europe/London')->setDate(2026, 10, 30)->setTime(12, 0));
        Http::preventStrayRequests();
        Storage::fake('public');
        $this->association = Organisation::where('slug', 'bulsca')->firstOrFail();
        $this->root = User::factory()->create();
        $this->root->assignRole(\Spatie\Permission\Models\Role::findOrCreate('super_admin', 'web'));
        $this->manager = User::factory()->create();
        $this->club = Organisation::create(['name' => 'Test Club', 'slug' => 'test-club', 'kind' => 'club', 'parent_id' => $this->association->id]);
        $this->managerMembership = Membership::create(['organisation_id' => $this->club->id, 'user_id' => $this->manager->id]);
        $this->committee = Committee::create(['organisation_id' => $this->club->id, 'name' => '2026 committee', 'starts_on' => '2026-09-01', 'ends_on' => '2027-08-31']);
        $this->managerRole = app(PortalAccess::class)->managerRole($this->club);
        $this->assign($this->managerMembership, $this->managerRole);
    }

    private function path(string $suffix = '', ?Organisation $organisation = null): string
    {
        return '/api/v1/portal/organisations/'.($organisation ?? $this->club)->id.$suffix;
    }

    private function assign(Membership $member, Role $role, ?Committee $committee = null): Appointment
    {
        return Appointment::create(['organisation_id' => $member->organisation_id, 'membership_id' => $member->id, 'committee_id' => ($committee ?? $this->committee)->id, 'role_id' => $role->id]);
    }

    private function member(?Organisation $organisation = null): Membership
    {
        return Membership::create(['organisation_id' => ($organisation ?? $this->club)->id, 'user_id' => User::factory()->create()->id]);
    }

    public function test_guests_get_json_unauthorized_and_no_member_data(): void
    {
        $this->getJson('/api/v1/portal/me')->assertUnauthorized();
        $this->getJson($this->path())->assertUnauthorized()->assertDontSee($this->manager->email);
    }

    public function test_sign_in_does_not_grant_membership_or_permissions(): void
    {
        $new = User::factory()->create();
        $this->actingAs($new)->getJson('/api/v1/portal/me')->assertOk()->assertJsonCount(0, 'data.organisations')->assertJsonPath('data.is_superadmin', false)->assertJsonPath('data.can_administer', false);
        $this->getJson($this->path())->assertNotFound();
    }

    public function test_root_can_create_an_affiliated_club_and_appoint_its_initial_manager(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->root)->postJson('/api/v1/portal/organisations', ['name' => 'New Club', 'administrator_email' => $user->email])->assertCreated()->assertJsonPath('data.parent_id', $this->association->id)->assertJsonPath('data.kind', 'club');
        $org = Organisation::findOrFail($response->json('data.id'));
        $this->assertEqualsCanonicalizing(array_keys(PortalAccess::CLUB), app(PortalAccess::class)->permissions($user, $org));
        $this->assertFalse($user->hasRole('super_admin'));
    }

    public function test_club_administrator_cannot_create_federation_members_or_list_other_clubs(): void
    {
        $this->actingAs($this->manager)->getJson('/api/v1/portal/organisations')->assertNotFound();
        $this->postJson('/api/v1/portal/organisations', ['name' => 'Other', 'administrator_email' => $this->manager->email])->assertNotFound();
    }

    public function test_people_can_belong_to_multiple_organisations_without_inheriting_parent_permissions(): void
    {
        Membership::create(['organisation_id' => $this->association->id, 'user_id' => $this->manager->id]);
        $this->actingAs($this->manager)->getJson('/api/v1/portal/me')->assertOk()->assertJsonCount(2, 'data.organisations')->assertJsonPath('data.is_superadmin', false);
        $this->postJson($this->path('/roles', $this->association), ['name' => 'Global', 'permissions' => ['clubs.manage']])->assertForbidden();
    }

    public function test_members_see_roster_names_and_committees_without_other_members_email_addresses(): void
    {
        $member = $this->member();
        $this->actingAs($member->user)->getJson($this->path())->assertOk()->assertJsonPath('data.members.0.name', $this->manager->name)->assertJsonCount(1, 'data.committees')->assertDontSee($this->manager->email)->assertJsonPath('data.organisation.permissions', []);
        $this->postJson($this->path('/members'), ['email' => $this->root->email])->assertForbidden();
        $this->postJson($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321'])->assertForbidden();
    }

    public function test_managers_can_add_existing_users_but_cannot_create_sso_accounts(): void
    {
        $user = User::factory()->create();
        $this->actingAs($this->manager)->postJson($this->path('/members'), ['email' => $user->email])->assertCreated();
        $this->postJson($this->path('/members'), ['email' => 'unknown@example.test'])->assertUnprocessable()->assertJsonValidationErrors('email');
        $this->assertDatabaseHas('portal_memberships', ['organisation_id' => $this->club->id, 'user_id' => $user->id, 'active' => true]);
    }

    public function test_other_club_requests_cannot_read_or_change_our_data(): void
    {
        $other = Organisation::create(['name' => 'Other', 'slug' => 'other', 'kind' => 'club', 'parent_id' => $this->association->id]);
        $user = $this->member($other)->user;
        $this->actingAs($user)->getJson($this->path())->assertNotFound();
        $this->postJson($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321'])->assertNotFound();
    }

    public function test_club_roles_cannot_receive_global_or_protected_permissions(): void
    {
        $this->actingAs($this->manager)->postJson($this->path('/roles'), ['name' => 'Escalation', 'permissions' => ['clubs.manage']])->assertUnprocessable();
        $this->postJson($this->path('/roles'), ['name' => 'Escalation', 'permissions' => ['super_admin']])->assertUnprocessable();
        $this->postJson($this->path('/roles'), ['name' => 'Escalation', 'permissions' => [], 'protected' => true])->assertUnprocessable();
        $this->patchJson($this->path('/roles/'.$this->managerRole->id), ['name' => 'Changed', 'permissions' => []])->assertForbidden();
    }

    public function test_role_editors_cannot_delegate_powers_they_do_not_hold(): void
    {
        $member = $this->member();
        $role = Role::create(['organisation_id' => $this->club->id, 'name' => 'Role editor', 'permissions' => ['roles.manage']]);
        $this->assign($member, $role);
        $this->actingAs($member->user)->postJson($this->path('/roles'), ['name' => 'More power', 'permissions' => ['members.manage']])->assertUnprocessable();
        $this->postJson($this->path('/appointments'), ['membership_id' => $member->id, 'committee_id' => $this->committee->id, 'role_id' => $this->managerRole->id])->assertForbidden();
    }

    public function test_assignments_must_use_a_member_committee_and_role_from_the_same_club(): void
    {
        $role = Role::create(['organisation_id' => $this->association->id, 'name' => 'Global', 'permissions' => ['clubs.manage']]);
        $member = $this->member();
        $this->actingAs($this->manager)->postJson($this->path('/appointments'), ['membership_id' => $member->id, 'committee_id' => $this->committee->id, 'role_id' => $role->id])->assertUnprocessable();
        $this->assertDatabaseMissing('portal_appointments', ['membership_id' => $member->id]);
    }

    public function test_custom_roles_can_be_created_and_assigned_with_real_effect(): void
    {
        $member = $this->member();
        $role = $this->actingAs($this->manager)->postJson($this->path('/roles'), ['name' => 'Web officer', 'permissions' => ['branding.manage']])->assertCreated()->json('data.id');
        $this->postJson($this->path('/appointments'), ['membership_id' => $member->id, 'committee_id' => $this->committee->id, 'role_id' => $role])->assertCreated();
        $this->actingAs($member->user)->postJson($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321'])->assertOk();
        $this->assertDatabaseHas('portal_organisations', ['id' => $this->club->id, 'primary_colour' => '#123456']);
    }

    public function test_future_and_expired_committee_terms_do_not_grant_permissions(): void
    {
        $member = $this->member();
        $future = Committee::create(['organisation_id' => $this->club->id, 'name' => 'Future', 'starts_on' => '2026-10-31']);
        $expired = Committee::create(['organisation_id' => $this->club->id, 'name' => 'Past', 'starts_on' => '2025-01-01', 'ends_on' => '2026-10-29']);
        $this->assign($member, $this->managerRole, $future);
        $this->assign($member, $this->managerRole, $expired);
        $this->actingAs($member->user)->getJson($this->path())->assertJsonPath('data.organisation.permissions', []);
        $this->postJson($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321'])->assertForbidden();
    }

    public function test_revocation_is_immediate_and_reactivation_does_not_restore_old_powers(): void
    {
        $member = $this->member();
        $this->assign($member, $this->managerRole);
        $this->actingAs($this->manager)->patchJson($this->path('/members/'.$member->id), ['active' => false])->assertOk();
        $this->actingAs($member->user)->getJson($this->path())->assertNotFound();
        $this->actingAs($this->manager)->patchJson($this->path('/members/'.$member->id), ['active' => true])->assertOk();
        $this->actingAs($member->user)->getJson($this->path())->assertOk()->assertJsonPath('data.organisation.permissions', []);
    }

    public function test_last_manager_cannot_be_removed_or_deactivated(): void
    {
        $appointment = $this->managerMembership->appointments()->first();
        $this->actingAs($this->manager)->deleteJson($this->path('/appointments/'.$appointment->id))->assertUnprocessable();
        $this->patchJson($this->path('/members/'.$this->managerMembership->id), ['active' => false])->assertUnprocessable();
        $this->assertTrue($this->managerMembership->fresh()->active);
        $this->assertNull($appointment->fresh()->revoked_at);
    }

    public function test_term_changes_cannot_silently_remove_the_last_current_manager(): void
    {
        $this->actingAs($this->manager)->patchJson($this->path('/committees/'.$this->committee->id), ['name' => '2026 committee', 'starts_on' => '2026-09-01', 'ends_on' => '2026-10-29'])->assertUnprocessable();
        $this->assertSame('2027-08-31', $this->committee->fresh()->ends_on->toDateString());
    }

    public function test_branding_validates_colours_and_rejects_active_svg_content(): void
    {
        $this->actingAs($this->manager)->postJson($this->path('/branding'), ['primary_colour' => 'red; background:url(x)', 'secondary_colour' => '#654321'])->assertUnprocessable();
        $this->post($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321', 'logo' => UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>bad()</script></svg>')], ['Accept' => 'application/json'])->assertUnprocessable();
        $this->assertNull($this->club->fresh()->logo_path);
    }

    public function test_logo_upload_is_saved_and_returned_without_a_storage_path(): void
    {
        $content = file_get_contents(base_path('storage/app/public/logo/blogo.png'));
        $this->actingAs($this->manager)->post($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321', 'logo' => UploadedFile::fake()->createWithContent('logo.png', $content)], ['Accept' => 'application/json'])->assertOk()->assertJsonStructure(['data' => ['logo_url']])->assertJsonMissingPath('data.logo_path');
        Storage::disk('public')->assertExists($this->club->fresh()->logo_path);
    }

    public function test_bootstrap_requires_an_explicit_existing_account_and_is_repeatable(): void
    {
        $user = User::factory()->create();
        $this->artisan('portal:bootstrap-superadmin', ['email' => $user->email])->assertSuccessful();
        $this->artisan('portal:bootstrap-superadmin', ['email' => $user->email])->assertSuccessful();
        $this->assertTrue($user->fresh()->hasRole('super_admin'));
        $this->assertSame(1, Membership::where('user_id', $user->id)->where('organisation_id', $this->association->id)->count());
        $this->artisan('portal:bootstrap-superadmin', ['email' => 'unknown@example.test'])->assertFailed();
    }

    public function test_csrf_is_required_for_authenticated_management_writes(): void
    {
        $this->app->instance('env', 'local');
        $this->actingAs($this->manager)->postJson($this->path('/roles'), ['name' => 'No token', 'permissions' => []])->assertStatus(419);
        $this->assertDatabaseMissing('portal_roles', ['name' => 'No token']);
    }

    public function test_explicit_bootstrap_restores_a_revoked_initial_appointment(): void
    {
        $user = User::factory()->create();
        $this->artisan('portal:bootstrap-superadmin', ['email' => $user->email])->assertSuccessful();
        $member = Membership::where('organisation_id', $this->association->id)->where('user_id', $user->id)->firstOrFail();
        $appointment = $member->appointments()->firstOrFail();
        $appointment->update(['revoked_at' => now()]);
        $this->assertNotNull($appointment->fresh()->revoked_at);
        $this->artisan('portal:bootstrap-superadmin', ['email' => $user->email])->assertSuccessful();
        $this->assertNull($appointment->fresh()->revoked_at);
    }

    public function test_audit_records_do_not_store_member_emails_or_request_payloads(): void
    {
        $member = User::factory()->create();
        $this->actingAs($this->manager)->postJson($this->path('/members'), ['email' => $member->email])->assertCreated();
        $audit = DB::table('portal_audit_events')->where('organisation_id', $this->club->id)->first();
        $this->assertStringNotContainsString($member->email, json_encode($audit));
        $this->assertSame('membership.added', $audit->action);
    }

    public function test_only_an_explicit_bulsca_club_management_permission_grants_affiliate_access(): void
    {
        $member = $this->member($this->association);
        $committee = Committee::create(['organisation_id' => $this->association->id, 'name' => 'BULSCA committee', 'starts_on' => '2026-09-01']);
        $role = Role::create(['organisation_id' => $this->association->id, 'name' => 'Club liaison', 'permissions' => ['clubs.manage']]);
        $this->assign($member, $role, $committee);
        $this->actingAs($member->user)->getJson('/api/v1/portal/organisations')->assertOk();
        $this->getJson($this->path())->assertOk()->assertJsonPath('data.organisation.permissions', array_keys(PortalAccess::CLUB));
        $role->update(['permissions' => []]);
        $this->getJson($this->path())->assertNotFound();
    }

    public function test_role_updates_take_effect_immediately_and_only_unused_roles_can_be_deleted(): void
    {
        $member = $this->member();
        $role = Role::create(['organisation_id' => $this->club->id, 'name' => 'Web officer', 'permissions' => ['branding.manage']]);
        $this->assign($member, $role);
        $this->actingAs($this->manager)->patchJson($this->path('/roles/'.$role->id), ['name' => 'Web officer', 'permissions' => []])->assertOk();
        $this->actingAs($member->user)->postJson($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321'])->assertForbidden();
        $this->actingAs($this->manager)->deleteJson($this->path('/roles/'.$role->id))->assertUnprocessable();
        $unused = Role::create(['organisation_id' => $this->club->id, 'name' => 'Unused', 'permissions' => []]);
        $this->deleteJson($this->path('/roles/'.$unused->id))->assertOk();
        $this->deleteJson($this->path('/roles/'.$this->managerRole->id))->assertForbidden();
        $this->assertDatabaseMissing('portal_roles', ['id' => $unused->id]);
    }

    public function test_an_explicit_new_appointment_is_required_after_reactivation(): void
    {
        $member = $this->member();
        $appointment = $this->assign($member, $this->managerRole);
        $this->actingAs($this->manager)->patchJson($this->path('/members/'.$member->id), ['active' => false])->assertOk();
        $this->patchJson($this->path('/members/'.$member->id), ['active' => true])->assertOk();
        $this->postJson($this->path('/appointments'), ['membership_id' => $member->id, 'committee_id' => $this->committee->id, 'role_id' => $this->managerRole->id])->assertCreated();
        $this->assertNull($appointment->fresh()->revoked_at);
        $this->assertContains('branding.manage', app(PortalAccess::class)->permissions($member->user, $this->club));
    }

    public function test_member_directory_search_is_paginated_and_rosters_exclude_inactive_members(): void
    {
        for ($index = 0; $index < 27; $index++) $this->member();
        $this->actingAs($this->manager)->getJson($this->path('?page=2'))->assertOk()->assertJsonCount(3, 'data.members')->assertJsonPath('data.pagination.total', 28);
        $this->getJson($this->path('?q='.urlencode($this->manager->name)))->assertOk()->assertJsonCount(1, 'data.members');
        $this->getJson($this->path('?page=-1'))->assertUnprocessable();
    }

    public function test_logo_storage_failure_keeps_the_previous_branding(): void
    {
        $this->club->update(['logo_path' => 'old.png']);
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('putFileAs')->once()->andReturn(false);
        $content = file_get_contents(base_path('storage/app/public/logo/blogo.png'));
        $this->actingAs($this->manager)->post($this->path('/branding'), ['primary_colour' => '#123456', 'secondary_colour' => '#654321', 'logo' => UploadedFile::fake()->createWithContent('logo.png', $content)], ['Accept' => 'application/json'])->assertStatus(500)->assertDontSee('old.png');
        $this->assertSame('old.png', $this->club->fresh()->logo_path);
        $this->assertSame('#B1040B', $this->club->fresh()->primary_colour);
    }

    public function test_audit_events_are_pruned_after_90_days(): void
    {
        foreach ([91, 89] as $days) DB::table('portal_audit_events')->insert(['organisation_id' => $this->club->id, 'actor_id' => $this->manager->id, 'action' => 'branding.updated', 'changes' => '{}', 'created_at' => now()->subDays($days)]);
        $this->artisan('portal:prune-audit')->assertSuccessful();
        $this->assertDatabaseCount('portal_audit_events', 1);
    }
}
