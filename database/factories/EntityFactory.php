<?php

namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition()
    {
        return [
            'entity_type' => $this->faker->randomElement([
                \App\Models\User::class,
                \App\Models\Organisation::class
            ]),
            'entity_ref_id' => function (array $attributes) {
                $model = $attributes['entity_type'];
                return $model::factory()->create()->id;
            },
            'privacy_level' => $this->faker->randomElement(['public', 'club_only', 'admins_only', 'private']),
        ];
    }

    // Specific states
    public function forUser($user)
    {
        return $this->state([
            'entity_type' => get_class($user),
            'entity_ref_id' => $user->id,
        ]);
    }

    public function forOrganisation($org)
    {
        return $this->state([
            'entity_type' => get_class($org),
            'entity_ref_id' => $org->id,
        ]);
    }
}   