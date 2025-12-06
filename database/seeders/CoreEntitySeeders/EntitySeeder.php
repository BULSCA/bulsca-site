<?php
namespace Database\Seeders\CoreEntitySeeders;

use Illuminate\Database\Seeder;
use App\Models\Organisation;
use App\Models\Entity;
use App\Models\Membership;
use Illuminate\Support\Str;

class EntitySeeder extends Seeder
{
    public function run()
    {
        try {
            $bulscaOrg = Organisation::where('name', 'Bulsca')->firstOrFail();

        } catch (\Exception $e) {
            $this->command->error("Bulsca organisation not found. Please run the OrganisationSeeder first.");
            return;
        }

        $bulscaEntity = Entity::where('entity_type', get_class($bulscaOrg))
            ->where('entity_ref_id', $bulscaOrg->id)
            ->first();

        if ($bulscaEntity) {
            $this->command->warn("Skipped (already exists): Bulsca organisation entity");
        } else {
            $bulscaEntity = Entity::create([
                'entity_type' => get_class($bulscaOrg),
                'entity_ref_id' => $bulscaOrg->id,
                'privacy_level' => 'public',
                'custom_id' => 'BBU002002',
            ]);

            $this->command->info("Created entity for Bulsca organisation");
        }



        $member_clubs = [
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

        foreach ($member_clubs as $mc) {
            $mcOrg = Organisation::where('name', $mc)->first();
            if (!$mcOrg) {
                $this->command->error("Organisation not found: {$mc}. Please run the OrganisationSeeder first.");
                continue;
            }

            $existingMC = Entity::where('entity_type', get_class($mcOrg))
                ->where('entity_ref_id', $mcOrg->id)
                ->first();

            if ($existingMC) {
                $this->command->warn("Skipped (already exists): {$mc}");
                
                // Check if membership exists
                $membershipExists = Membership::where('parent_entity_id', $bulscaEntity->id)
                    ->where('child_entity_id', $existingMC->id)
                    ->exists();
                    
                if (!$membershipExists) {
                    Membership::create([
                        'parent_entity_id' => $bulscaEntity->id,
                        'child_entity_id' => $existingMC->id,
                        'role' => 'member',
                    ]);
                    $this->command->info("Created membership for {$mc} to Bulsca");
                }
                
                continue;
            }

            $first2letters = Str::upper(Str::substr($mc, 0, 2));

            // generate a unique 6-digit numeric suffix for custom_id (no dots/spaces)
            do {
                $suffix = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $customId = 'C' . $first2letters . $suffix;
            } while (Entity::where('custom_id', $customId)->exists());

            $clubEntity = Entity::create([
                'entity_type' => get_class($mcOrg),
                'entity_ref_id' => $mcOrg->id,
                'privacy_level' => 'public',
                'custom_id' => $customId,
            ]);

            // Create membership linking the club to Bulsca
            Membership::create([
                'parent_entity_id' => $bulscaEntity->id,
                'child_entity_id' => $clubEntity->id,
                'role' => 'member',
            ]);

            $this->command->info("Created Organisation: {$mc} and linked to Bulsca");
        }
    }
}