<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return ['title' => $this->faker->sentence(), 'content' => '<p>News from BULSCA.</p>',
            'author' => null, 'pinned' => false, 'views' => 0, 'thumbs_up' => 0, 'thumbs_down' => 0];
    }
}
