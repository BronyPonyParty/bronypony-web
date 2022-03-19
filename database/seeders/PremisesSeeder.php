<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class PremisesSeeder extends Seeder
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
                'organization_id' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ];
        }

        for ($i = 11; $i <= 16; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 2,
                'organization_id' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        for ($i = 1; $i <= 8; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 1,
                'organization_id' => 2,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        for ($i = 1; $i <= 12; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 1,
                'organization_id' => 3,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        for ($i = 13; $i <= 20; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 2,
                'organization_id' => 3,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        for ($i = 21; $i <= 30; $i++) {
            $data[] = [
                'number' => $i,
                'floor' => 3,
                'organization_id' => 3,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        DB::table('premises')->insert($data);
    }
}
