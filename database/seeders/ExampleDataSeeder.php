<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Organisation;
use App\Models\Entity;
use App\Models\Membership;

class ExampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a user
        $user = User::factory()->create(['name' => 'Alice']);

        // Create entity for user
        $entity = Entity::create([
            'entity_type' => get_class($user),
            'entity_ref_id' => $user->id,
            'privacy_level' => 'club_only'
        ]);

        // Create organisation
        $org = Organisation::create(['name' => 'Test Club', 'owner_entity_id' => $entity->id]);

        // Create org entity
        $orgEntity = Entity::create([
            'entity_type' => get_class($org),
            'entity_ref_id' => $org->id,
            'privacy_level' => 'public'
        ]);

        // Add user to org
        Membership::create([
            'parent_entity_id' => $orgEntity->id,
            'child_entity_id' => $entity->id,
            'role' => 'admin'
        ]);
    }   
}
