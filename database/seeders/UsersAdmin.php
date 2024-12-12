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
            ],
            [
                'login' => 'Bassile',
                'first_name' => 'Никита',
                'last_name' => 'Костышев',
                'middle_name' => '',
                'email' => '',
                'password' => 'zxcasdqwe',
            ],
            [
                'login' => 'Valter',
                'first_name' => 'Александ',
                'last_name' => 'Вальтер',
                'middle_name' => '',
                'email' => '',
                'password' => 'qazxswedc',
            ],
            [
                'login' => 'guest',
                'first_name' => '',
                'last_name' => '',
                'middle_name' => '',
                'email' => '',
                'password' => '',
            ],
        ]);
    }
}
