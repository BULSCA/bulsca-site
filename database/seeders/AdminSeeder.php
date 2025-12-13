<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $name = 'Bulsca Admin';
        $email = 'data@bulsca.co.uk';

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            $this->command->warn("Skipped (already exists): {$name}");
            return;
        }

        // Create roles and permissions
        $this->command->info("Setting up roles and permissions...");
        Artisan::call('admin:rp-generate');

        // Create admin user
        Artisan::call('admin:create', [
            'name' => $name,
            'email' => $email,
        ]);

        $this->command->info("Admin user created via admin:create command");
    }
}