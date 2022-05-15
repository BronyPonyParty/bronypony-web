<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Movement_listSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'premise_id' => 3,
            'movement_technic_id' => 1
        ];

        $data[] = [
            'premise_id' => 5,
            'movement_technic_id' => 1
        ];

        $data[] = [
            'premise_id' => 2,
            'movement_technic_id' => 2
        ];

        $data[] = [
            'premise_id' => 4,
            'movement_technic_id' => 2
        ];

        $data[] = [
            'premise_id' => 2,
            'movement_technic_id' => 3
        ];

        $data[] = [
            'premise_id' => 15,
            'movement_technic_id' => 3
        ];

        $data[] = [
            'premise_id' => 13,
            'movement_technic_id' => 4
        ];

        $data[] = [
            'premise_id' => 15,
            'movement_technic_id' => 4
        ];

        $data[] = [
            'premise_id' => 16,
            'movement_technic_id' => 5
        ];

        $data[] = [
            'premise_id' => 8,
            'movement_technic_id' => 5
        ];

        DB::table('movement_lists')->insert($data);
    }
}
