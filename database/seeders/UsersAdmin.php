<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'login' => 'NoteBade',
                'first_name' => 'Dmitriy',
                'last_name' => 'Vasiliev',
                'middle_name' => 'Igorevich',
                'email' => 'dimondi1010@gmail.com',
                'password' => 'qweasdzxc',
                'active' => 1,
            ],
            [
                'login' => 'Bassile',
                'first_name' => 'Никита',
                'last_name' => 'Костышев',
                'middle_name' => '',
                'email' => '',
                'password' => 'zxcasdqwe',
                'active' => 1,
            ],
            [
                'login' => 'Valter',
                'first_name' => 'Александ',
                'last_name' => 'Вальтер',
                'middle_name' => '',
                'email' => '',
                'password' => 'qazxswedc',
                'active' => 1,
            ],
            [
                'login' => 'guest',
                'first_name' => '',
                'last_name' => '',
                'middle_name' => '',
                'email' => '',
                'password' => '',
                'active' => 1,
            ],
            [
                'login' => 'student',
                'first_name' => 'ученик',
                'last_name' => '11',
                'middle_name' => 'А',
                'email' => '',
                'password' => 'student1',
                'active' => 1,
            ],
        ]);
    }
}
