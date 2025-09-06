<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates and admin user with the given name';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        $password = Str::random(16);
        $passwordHash = Hash::make($password);

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $passwordHash;
        $user->save();

        $user->assignRole('super_admin', 'admin');

        $this->info("Made Admin Account with Email: {$email} and Password: {$password}");
    }
}
