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

        DB::table('discipline_groups')->insert([
            // 7 Б класс (id = 1)
            ['discipline_id' => 1, 'group_id' => 1], // Математика
            ['discipline_id' => 2, 'group_id' => 1], // Физика
            ['discipline_id' => 3, 'group_id' => 1], // Химия
            ['discipline_id' => 4, 'group_id' => 1], // Информатика
            ['discipline_id' => 5, 'group_id' => 1], // Биология

            // 9 А класс (id = 2)
            ['discipline_id' => 6, 'group_id' => 2], // История
            ['discipline_id' => 7, 'group_id' => 2], // География
            ['discipline_id' => 8, 'group_id' => 2], // Литература
            ['discipline_id' => 9, 'group_id' => 2], // Философия
            ['discipline_id' => 10, 'group_id' => 2], // Экономика

            // 11 А класс (id = 3)
            ['discipline_id' => 11, 'group_id' => 3], // Право
            ['discipline_id' => 12, 'group_id' => 3], // Иностранные языки
            ['discipline_id' => 13, 'group_id' => 3], // Музыка
            ['discipline_id' => 14, 'group_id' => 3], // Физкультура
        ]);

        // Привязываем все учебные материалы к классам
        DB::table('subject_group')->insert([
            // 7 Б класс (id = 1)
            ['subject_id' => 1, 'group_id' => 1], // Математика: Алгебра и Геометрия
            ['subject_id' => 2, 'group_id' => 1], // Основы физики
            ['subject_id' => 3, 'group_id' => 1], // Химия: Опыты и Теория
            ['subject_id' => 4, 'group_id' => 1], // Программирование для начинающих
            ['subject_id' => 5, 'group_id' => 1], // Биология: Структура живых существ

            // 9 А класс (id = 2)
            ['subject_id' => 6, 'group_id' => 2], // История России
            ['subject_id' => 7, 'group_id' => 2], // География мира
            ['subject_id' => 8, 'group_id' => 2], // Литература России
            ['subject_id' => 9, 'group_id' => 2], // Основы философии
            ['subject_id' => 10, 'group_id' => 2], // Экономика для начинающих

            // 11 А класс (id = 3)
            ['subject_id' => 11, 'group_id' => 3], // Право: Основы законодательства
            ['subject_id' => 12, 'group_id' => 3], // Иностранные языки: Английский
            ['subject_id' => 13, 'group_id' => 3], // Основы музыкальной теории
            ['subject_id' => 14, 'group_id' => 3], // Физкультура: Здоровье и тренировки
        ]);

        DB::table('user_group')->insert([
            ['user_id' => 5, 'group_id' => 3],
            ['user_id' => 8, 'group_id' => 2],
            ['user_id' => 7, 'group_id' => 1],
        ]);
    }
}
