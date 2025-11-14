<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Comp Report',
            'News',
            'League',
            'Committee',
            'Resources',
            'Rules',
            'Student Championships',
            'Welfare',
        ];

        foreach ($tags as $tagName) {
            $existingTag = Tag::where('slug', Str::slug($tagName))->first();

            if ($existingTag) {
                $this->command->warn("Skipped (already exists): {$tagName}");
                continue;
            }

            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);

            $this->command->info("Created tag: {$tagName}");
        }
    }
}