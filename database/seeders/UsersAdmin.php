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
                'password' => 'qwertyasdfghzxcvbn',
            ],
            [
                'login' => 'Bassile',
                'first_name' => 'Nikita',
                'last_name' => 'Kosteshev',
                'middle_name' => '',
                'email' => '',
                'password' => 'qazxswedcvfr',
            ],
        ]);
    }
}
