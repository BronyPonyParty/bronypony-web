<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = [
            'name' => 'Best computers',
            'phone_number' => '79565805965',
            'address' => '672026, г. Моршанск, ул. Гурзуфская, дом 3',
            'status' => 0
        ];

        $data[] = [
            'name' => 'Best of the Best',
            'phone_number' => '79972245714',
            'address' => '168130, г. Туймазы, ул. Новомещерский проезд, дом 174',
            'status' => 0
        ];

        DB::table('providers')->insert($data);
    }
}
