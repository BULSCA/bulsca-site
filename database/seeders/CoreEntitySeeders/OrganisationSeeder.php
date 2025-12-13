<?php
namespace Database\Seeders\CoreEntitySeeders;

use Illuminate\Database\Seeder;
use App\Models\Organisation;
use Illuminate\Support\Str;

class OrganisationSeeder extends Seeder
{
    public function run()
    {
        $organisations = [
            'Bulsca',
            'Birmingham',
            'Bristol',
            'Loughborough',
            'Nottingham',
            'Oxford',
            'Plymouth',
            'Sheffield',
            'Southampton',
            'Swansea',
            'Warwick',
        ];

        foreach ($organisations as $org) {
            $existingOrganisation = Organisation::where('name', $org)->first();

            if ($existingOrganisation) {
                $this->command->warn("Skipped (already exists): {$org}");
                continue;
            }

            Organisation::create([
                'name' => $org,
            ]);

            $this->command->info("Created Organisation: {$org}");
        }
    }
}