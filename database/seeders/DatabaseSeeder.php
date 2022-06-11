<?php

namespace Database\Seeders;

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
        $this->call(OrganizationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PremiseSeeder::class);
        $this->call(TechnicSeeder::class);
        $this->call(ReportSeeder::class);
        $this->call(RepairSeeder::class);
        $this->call(MovingTechnicSeeder::class);
    }
}
