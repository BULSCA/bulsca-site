<?php
namespace Database\Seeders\CoreEntitySeeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class CoreUserSeeder extends Seeder
{
    public function run()
    {
        $core_users = [
            'Birmingham Admin',
            'Bristol Admin',
            'Loughborough Admin',
            'Nottingham Admin',
            'Oxford Admin',
            'Plymouth Admin',
            'Sheffield Admin',
            'Southampton Admin',
            'Swansea Admin',
            'Warwick Admin',
        ];

        foreach ($core_users as $cu) {
            $existingUser = User::where('name', $cu)->first();

            if ($existingUser) {
                $this->command->warn("Skipped (already exists): {$cu}");
                continue;
            }

            $firstName = explode(' ', trim($cu))[0];

            User::create([
                'name' => $cu,
                'email' => Str::slug($firstName, '_') . '@example.com',
                'password' => bcrypt($firstName . '@password'),
            ]);

            $this->command->info("Created user: {$cu}");
        }
    }
}