<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = [
            'name' => 'Office workers',
            'address' => '672520, г. Сураж, ул. Чапаевский пер, дом 57',
            'phone_number' => '79336609156',
            'registration_date' => 1589544995,
            'status' => 0
        ];

        $data[] = [
            'name' => 'Best college in town',
            'address' => '607204, г. Курагино, ул. Золотистый пер, дом 177',
            'phone_number' => '79616013079',
            'registration_date' => 1533259600,
            'status' => 0
        ];

        DB::table('organizations')->insert($data);
    }
}
