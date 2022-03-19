<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Provider;
use App\Models\Technic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Organization::factory(3)->create();
        User::factory(10)->create();
        Provider::factory(3)->create();
        Technic::factory(30)->create();
        $this->call(PremisesSeeder::class);
    }
}
