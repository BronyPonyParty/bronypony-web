<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $password = '123456';
        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Путинцев',
            'firstname' => 'Александр',
            'login' => 'paa',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79631974379',
            'mail' => 'tat.putintsewa@yandex.ru',
            'organization_id' => 1,
            'status' => 8
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Шамшин',
            'firstname' => 'Даниил',
            'login' => 'sde',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => null,
            'mail' => 'ShamshinDanil@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Попов',
            'firstname' => 'Михаил',
            'login' => 'pma',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => null,
            'mail' => 'Mikhail@yandex.ru',
            'organization_id' => 2,
            'status' => 8
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Киреев',
            'firstname' => 'Олег',
            'login' => 'kov',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => null,
            'mail' => 'Oleg@yandex.ru',
            'organization_id' => 2,
            'status' => 1
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Шмидт',
            'firstname' => 'Лукерья',
            'login' => 'sle',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79078984772',
            'mail' => 'Lukerya@yandex.ru',
            'organization_id' => 2,
            'status' => 2
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Поднебесная',
            'firstname' => 'Степанида',
            'login' => 'psk',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79122103454',
            'mail' => 'Stepanida@yandex.ru',
            'organization_id' => 2,
            'status' => 4
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Филлипов',
            'firstname' => 'Демьян',
            'login' => 'fdd',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79599378529',
            'mail' => 'Filippov@yandex.ru',
            'organization_id' => 2,
            'status' => 4
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Преснякова',
            'firstname' => 'Алевтина',
            'login' => 'pas',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79550408198',
            'mail' => 'Alevtina@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Чехов',
            'firstname' => 'Карл',
            'login' => 'ckk',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79253985730',
            'mail' => 'Karl@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $salt = base64_encode(random_bytes(12));
        $hash = md5($password.$salt);
        for ($i = 0; $i < 64000; $i++) {
            $hash = md5($hash);
        }

        $data[] = [
            'lastname' => 'Стацевич',
            'firstname' => 'Виктория',
            'login' => 'svm',
            'password' => $hash,
            'salt' => $salt,
            'phone_number' => '79085327084',
            'mail' => 'Victoria@yandex.ru',
            'organization_id' => 1,
            'status' => 2
        ];

        DB::table('users')->insert($data);
    }
}
