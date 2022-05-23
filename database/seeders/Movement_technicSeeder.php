<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Movement_technicSeeder extends Seeder
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
            'date' => 1647015123
        ];

        $data[] = [
            'user_id' => 2,
            'technic_id' => 15,
            'date' => 1647368265
        ];

        $data[] = [
            'user_id' => 9,
            'technic_id' => 2,
            'date' => 1649843112
        ];

        $data[] = [
            'user_id' => 4,
            'technic_id' => 33,
            'date' => 1610629376
        ];

        $data[] = [
            'user_id' => 5,
            'technic_id' => 56,
            'date' => 1647284204
        ];

        DB::table('movement_technics')->insert($data);
    }
}
