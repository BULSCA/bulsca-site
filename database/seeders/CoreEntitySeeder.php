<?php

namespace Database\Seeders;

use Defuse\Crypto\Core;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CoreEntitySeeders\OrganisationSeeder;
use Database\Seeders\CoreEntitySeeders\CoreUserSeeder;
use Database\Seeders\CoreEntitySeeders\EntitySeeder;

class CoreEntitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            OrganisationSeeder::class,
            CoreUserSeeder::class,
            EntitySeeder::class,
        ]);
    }
}