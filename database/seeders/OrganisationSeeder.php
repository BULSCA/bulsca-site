<?php

namespace Database\Seeders;

use App\Models\Organisation\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test organisation
        $org = Organisation::create([
            'name' => 'British Universities Lifesaving Clubs Association',
            'short_name' => 'BULSCA',
            'type' => 'national_body',
            'description' => 'The national governing body for student lifesaving sport',
            'email' => 'info@bulsca.co.uk',
            'website' => 'https://bulsca.co.uk',
        ]);

        // Assign the first super admin as owner
        $admin = User::role('super_admin')->first();
        
        if ($admin) {
            $org->managers()->attach($admin->id, ['role' => 'owner']);
        }

        // Create a sample club
        $club = Organisation::create([
            'name' => 'Sample University Lifesaving Club',
            'short_name' => 'SULC',
            'type' => 'club',
            'parent_id' => $org->id,
            'description' => 'A sample club for testing',
        ]);

        if ($admin) {
            $club->managers()->attach($admin->id, ['role' => 'owner']);
        }
    }
}