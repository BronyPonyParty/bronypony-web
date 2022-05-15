<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator;

class RepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $data[] = [
            'report_id' => 1,
            'repairman_id' => 8,
            'description' => ''
        ];

        $data[] = [
            'report_id' => 2,
            'repairman_id' => 2,
            'description' => $faker->realText()
        ];

        $data[] = [
            'report_id' => 3,
            'repairman_id' => 10,
            'description' => $faker->realText(120)
        ];

        $data[] = [
            'report_id' => 4,
            'repairman_id' => 2,
            'description' => ''
        ];

        $data[] = [
            'report_id' => 5,
            'repairman_id' => 4,
            'description' => $faker->realText(512)
        ];

        $data[] = [
            'report_id' => 6,
            'repairman_id' => 7,
            'description' => $faker->realText(340)
        ];

        DB::table('repairs')->insert($data);
    }
}
