<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return ['name' => $name, 'slug' => \Illuminate\Support\Str::slug($name)];
    }
}
