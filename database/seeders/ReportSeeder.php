<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator;

class ReportSeeder extends Seeder
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
            'technic_id' => 5,
            'user_id' => 10,
            'description' => $faker->realText(),
            'create_date' => 1652623012,
            'complete_date' => null,
            'status' => 1
        ];

        $data[] = [
            'technic_id' => 2,
            'user_id' => 10,
            'description' => $faker->realText(512),
            'create_date' => 1652727404,
            'complete_date' => null,
            'status' => 1
        ];

        $data[] = [
            'technic_id' => 19,
            'user_id' => 10,
            'description' => $faker->realText(300),
            'create_date' => 1655153113,
            'complete_date' => 1655201636,
            'status' => 4
        ];

        $data[] = [
            'technic_id' => 20,
            'user_id' => 10,
            'description' => $faker->realText(120),
            'create_date' => 1655292842,
            'complete_date' => 1655317435,
            'status' => 4
        ];

        $data[] = [
            'technic_id' => 33,
            'user_id' => 5,
            'description' => $faker->realText(100),
            'create_date' => 1657568422,
            'complete_date' => 1657643531,
            'status' => 4
        ];

        $data[] = [
            'technic_id' => 39,
            'user_id' => 5,
            'description' => $faker->realText(66),
            'create_date' => 1658157214,
            'complete_date' => 1658174551,
            'status' => 4
        ];

        DB::table('reports')->insert($data);
    }
}
