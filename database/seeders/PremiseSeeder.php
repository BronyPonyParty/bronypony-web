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

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 1,
                'organization_id' => 1
            ];
        }

        for ($i = 11; $i <= 16; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 2,
                'organization_id' => 1
            ];
        }

        for ($i = 1; $i <= 8; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 1,
                'organization_id' => 2
            ];
        }

        DB::table('premises')->insert($data);
    }
}
