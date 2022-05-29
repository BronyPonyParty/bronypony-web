<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PremiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 101; $i <= 112; $i++) {
            $data[] = [
                'number' => $i,
                'organization_id' => 1
            ];
        }

        for ($i = 201; $i <= 212; $i++) {
            $data[] = [
                'number' => $i,
                'organization_id' => 1
            ];
        }

        for ($i = 101; $i <= 115; $i++) {
            $data[] = [
                'number' => $i,
                'organization_id' => 2
            ];
        }

        DB::table('premises')->insert($data);
    }
}
