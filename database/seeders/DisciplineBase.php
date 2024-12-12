<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplineBase extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('disciplines')->insert([
            [
                'code' => 'D001',
                'name' => 'Математика',
                'description' => 'Основы алгебры, геометрии и математического анализа.',
                'user_id' => 1,
            ],
            [
                'code' => 'D002',
                'name' => 'Физика',
                'description' => 'Изучение законов природы и физических явлений.',
                'user_id' => 2,
            ],
            [
                'code' => 'D003',
                'name' => 'Химия',
                'description' => 'Основы органической и неорганической химии.',
                'user_id' => 3,
            ],
            [
                'code' => 'D004',
                'name' => 'Информатика',
                'description' => 'Основы программирования и алгоритмов.',
                'user_id' => 1,
            ],
            [
                'code' => 'D005',
                'name' => 'Биология',
                'description' => 'Изучение живых организмов и экосистем.',
                'user_id' => 2,
            ],
            [
                'code' => 'D006',
                'name' => 'История',
                'description' => 'Изучение событий прошлого и их влияния на настоящее.',
                'user_id' => 3,
            ],
            [
                'code' => 'D007',
                'name' => 'География',
                'description' => 'Изучение земли, природных ресурсов и климата.',
                'user_id' => 1,
            ],
            [
                'code' => 'D008',
                'name' => 'Литература',
                'description' => 'Классическая и современная литература, анализ произведений.',
                'user_id' => 2,
            ],
            [
                'code' => 'D009',
                'name' => 'Философия',
                'description' => 'Изучение мировоззрений и основ философского мышления.',
                'user_id' => 3,
            ],
            [
                'code' => 'D010',
                'name' => 'Экономика',
                'description' => 'Основы экономики и финансовых систем.',
                'user_id' => 1,
            ],
            [
                'code' => 'D011',
                'name' => 'Право',
                'description' => 'Основы правовых норм и законодательства.',
                'user_id' => 2,
            ],
            [
                'code' => 'D012',
                'name' => 'Иностранные языки',
                'description' => 'Изучение английского, немецкого и других языков.',
                'user_id' => 3,
            ],
            [
                'code' => 'D013',
                'name' => 'Музыка',
                'description' => 'Изучение теории музыки и музыкальных произведений.',
                'user_id' => 1,
            ],
            [
                'code' => 'D014',
                'name' => 'Физкультура',
                'description' => 'Основы здорового образа жизни и спортивных тренировок.',
                'user_id' => 2,
            ],
        ]);
    }
}
