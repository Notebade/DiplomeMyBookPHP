<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('qweasdzxc'),
                'active' => 1,
            ],
            [
                'login' => 'Bassile',
                'first_name' => 'Никита',
                'last_name' => 'Костышев',
                'middle_name' => '',
                'email' => '',
                'password' => Hash::make('zxcasdqwe'),
                'active' => 1,
            ],
            [
                'login' => 'Valter',
                'first_name' => 'Александ',
                'last_name' => 'Вальтер',
                'middle_name' => '',
                'email' => '',
                'password' => Hash::make('qazxswedc'),
                'active' => 1,
            ],
            [
                'login' => 'guest',
                'first_name' => '',
                'last_name' => '',
                'middle_name' => '',
                'email' => '',
                'password' => '',
                'active' => 0,
            ],
            [
                'login' => 'student11',
                'first_name' => 'ученик',
                'last_name' => '11',
                'middle_name' => 'А',
                'email' => '',
                'password' => Hash::make('student11а'),
                'active' => 1,
            ],
            [
                'login' => 'parent11',
                'first_name' => 'родитель ученика',
                'last_name' => '11',
                'middle_name' => 'А',
                'email' => '',
                'password' => Hash::make('parent11а'),
                'active' => 1,
            ],
            [
                'login' => 'student7B',
                'first_name' => 'ученик',
                'last_name' => '7',
                'middle_name' => 'Б',
                'email' => '',
                'password' => Hash::make('student7b'),
                'active' => 1,
            ],
            [
                'login' => 'student9',
                'first_name' => 'ученик',
                'last_name' => '9',
                'middle_name' => 'А',
                'email' => '',
                'password' => Hash::make('student9а'),
                'active' => 1,
            ],
            [
                'login' => 'yurchenko_t',
                'first_name' => 'Татьяна',
                'last_name' => 'Юрченко',
                'middle_name' => 'Владиславовна',
                'email' => 'yu_ta@list.ru',
                'password' => Hash::make('KexibqGhtgjl#1'),
                'active' => 1,
            ],
            [
                'login' => 'yurchenko_a',
                'first_name' => 'Татьяна',
                'last_name' => 'Юрченко',
                'middle_name' => 'Владиславовна',
                'email' => 'yu_ta@list.ru',
                'password' => Hash::make('KexibqGhtgjl#1'),
                'active' => 1,
            ],
        ]);
    }
}
