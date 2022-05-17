<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovingTechnicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'user_id' => 2,
            'technic_id' => 19,
            'premise_id' => 3,
            'date' => 1647015123
        ];

        $data[] = [
            'user_id' => 2,
            'technic_id' => 2,
            'premise_id' => 5,
            'date' => 1647368265
        ];

        $data[] = [
            'user_id' => 9,
            'technic_id' => 2,
            'premise_id' => 10,
            'date' => 1649843112
        ];

        $data[] = [
            'user_id' => 4,
            'technic_id' => 33,
            'premise_id' => 17,
            'date' => 1610629376
        ];

        $data[] = [
            'user_id' => 5,
            'technic_id' => 56,
            'premise_id' => 20,
            'date' => 1647284204
        ];

        DB::table('moving_technics')->insert($data);
    }
}
