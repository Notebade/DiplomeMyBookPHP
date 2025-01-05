<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'code' => '7B',
                'name' => '7 Б',
            ],
            [
                'code' => '9A',
                'name' => '9 А',
            ],
            [
                'code' => '11A',
                'name' => '11 А',
            ],
        ]);
    }
}
