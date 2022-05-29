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
        $data[] = [
            'lastname' => 'Путинцев',
            'firstname' => 'Александр',
            'middlename' => 'Александрович',
            'login' => 'paa',
            'password' => md5('123456'),
            'phone_number' => '79631974379',
            'mail' => 'tat.putintsewa@yandex.ru',
            'organization_id' => 1,
            'status' => 8
        ];

        $data[] = [
            'lastname' => 'Шамшин',
            'firstname' => 'Даниил',
            'middlename' => 'Евгеньевич',
            'login' => 'sde',
            'password' => md5('123456'),
            'phone_number' => null,
            'mail' => 'ShamshinDanil@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $data[] = [
            'lastname' => 'Попов',
            'firstname' => 'Михаил',
            'middlename' => null,
            'login' => 'pma',
            'password' => md5('123456'),
            'phone_number' => null,
            'mail' => 'Mikhail@yandex.ru',
            'organization_id' => 2,
            'status' => 8
        ];

        $data[] = [
            'lastname' => 'Киреев',
            'firstname' => 'Олег',
            'middlename' => 'Вячеславович',
            'login' => 'kov',
            'password' => md5('123456'),
            'phone_number' => null,
            'mail' => 'Oleg@yandex.ru',
            'organization_id' => 2,
            'status' => 1
        ];

        $data[] = [
            'lastname' => 'Шмидт',
            'firstname' => 'Лукерья',
            'middlename' => 'Ермаковна',
            'login' => 'sle',
            'password' => md5('123456'),
            'phone_number' => '79078984772',
            'mail' => 'Lukerya@yandex.ru',
            'organization_id' => 2,
            'status' => 2
        ];

        $data[] = [
            'lastname' => 'Поднебесная',
            'firstname' => 'Степанида',
            'middlename' => 'Кирилловна',
            'login' => 'psk',
            'password' => md5('123456'),
            'phone_number' => '79122103454',
            'mail' => 'Stepanida@yandex.ru',
            'organization_id' => 2,
            'status' => 4
        ];

        $data[] = [
            'lastname' => 'Филлипов',
            'firstname' => 'Демьян',
            'middlename' => 'Дмитриевич',
            'login' => 'fdd',
            'password' => md5('123456'),
            'phone_number' => '79599378529',
            'mail' => 'Filippov@yandex.ru',
            'organization_id' => 2,
            'status' => 4
        ];

        $data[] = [
            'lastname' => 'Преснякова',
            'firstname' => 'Алевтина',
            'middlename' => 'Сергеевна',
            'login' => 'pas',
            'password' => md5('123456'),
            'phone_number' => '79550408198',
            'mail' => 'Alevtina@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $data[] = [
            'lastname' => 'Чехов',
            'firstname' => 'Карл',
            'middlename' => 'Константинович',
            'login' => 'ckk',
            'password' => md5('123456'),
            'phone_number' => '79253985730',
            'mail' => 'Karl@yandex.ru',
            'organization_id' => 1,
            'status' => 4
        ];

        $data[] = [
            'lastname' => 'Стацевич',
            'firstname' => 'Виктория',
            'middlename' => 'Максимовна',
            'login' => 'svm',
            'password' => md5('123456'),
            'phone_number' => '79085327084',
            'mail' => 'Victoria@yandex.ru',
            'organization_id' => 1,
            'status' => 2
        ];

        DB::table('users')->insert($data);
    }
}
