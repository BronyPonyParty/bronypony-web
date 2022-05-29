<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Facades\DB;

class TechnicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $data = [];

        for ($i = 0; $i < 30; $i++) {
            $data[] = [
                'name' => rand(0, 10) <= 6 ? 'Компьютер' : 'Принтер',
                'number' => $faker->unique()->buildingNumber(),
                'date_purchase' => $faker->unixTime(),
                'description' => $faker->realTextBetween(200, 1000),
                'provider_id' => rand(1, 2),
                'organization_id' => 1,
                'status' => rand(0, 10) <= 8 ? 1 : 2
            ];
        }

        for ($i = 0; $i < 30; $i++) {
            $data[] = [
                'name' => rand(0, 10) <= 6 ? 'Компьютер' : 'Принтер',
                'number' => $faker->unique()->buildingNumber(),
                'date_purchase' => $faker->unixTime(),
                'description' => $faker->realTextBetween(200, 1000),
                'provider_id' => rand(1, 2),
                'organization_id' => 2,
                'status' => rand(0, 10) <= 8 ? 1 : 2
            ];
        }

        DB::table('technics')->insert($data);
    }
}
