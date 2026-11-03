<?php

namespace App\Console\Commands;

use App\Models\Portal\Membership;
use App\Models\Portal\Organisation;
use App\Models\Portal\{Appointment, Committee};
use App\Services\PortalAccess;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BootstrapPortal extends Command
{
    protected $signature = 'portal:bootstrap-superadmin {email : Email of an existing SSO account}';
    protected $description = 'Explicitly grant the portal superadmin role and BULSCA membership to an existing SSO account';

    public function handle(): int
    {
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($this->argument('email'))])->first();
        if (! $user) { $this->error('No account found. This person must sign in through SSO first.'); return self::FAILURE; }
        DB::transaction(function () use ($user) {
            $role = \Spatie\Permission\Models\Role::findOrCreate('super_admin', 'web');
            $user->assignRole($role);
            $association = Organisation::where('slug', 'bulsca')->firstOrFail();
            $member = Membership::firstOrCreate(['organisation_id' => $association->id, 'user_id' => $user->id]);
            $member->update(['active' => true]);
            $committee = Committee::firstOrCreate(['organisation_id' => $association->id, 'name' => 'Initial committee'], ['starts_on' => now('Europe/London')->toDateString()]);
            $manager = app(PortalAccess::class)->managerRole($association);
            Appointment::updateOrCreate(['organisation_id' => $association->id, 'membership_id' => $member->id, 'committee_id' => $committee->id, 'role_id' => $manager->id], ['revoked_at' => null]);
            app(PortalAccess::class)->audit($user, $association, 'superadmin.bootstrapped', ['membership_id' => $member->id]);
        });
        $this->info('Superadmin access and BULSCA membership granted. No other account was changed.');
        return self::SUCCESS;
    }
}
