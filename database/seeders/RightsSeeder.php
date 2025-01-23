<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rights')->insert([
            [
                'code' => 'admin',
                'name' => 'Админ',
            ],
            [
                'code' => 'teacher',
                'name' => 'Учитель',
            ],
            [
                'code' => 'student',
                'name' => 'Ученик',
            ],
            [
                'code' => 'parent',
                'name' => 'Родитель',
            ],
        ]);
        DB::table('user_right')->insert([
            [
                'user_id' => '1',
                'right_id' => '1',
            ],
            [
                'user_id' => '2',
                'right_id' => '1',
            ],
            [
                'user_id' => '3',
                'right_id' => '1',
            ],
            [
                'user_id' => '5',
                'right_id' => '3',
            ],
            [
                'user_id' => '7',
                'right_id' => '3',
            ],
            [
                'user_id' => '8',
                'right_id' => '3',
            ],
            [
                'user_id' => '9',
                'right_id' => '2',
            ],
            [
                'user_id' => '10',
                'right_id' => '1',
            ],
        ]);
    }
}
