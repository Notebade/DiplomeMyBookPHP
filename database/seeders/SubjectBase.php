<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectBase extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'code' => 'B001',
                'name' => 'Математика: Алгебра и Геометрия',
                'description' => 'Учебник для школьников по алгебре и геометрии.',
                'user_id' => 1,
                'discipline_id' => 1,
            ],
            [
                'code' => 'B002',
                'name' => 'Основы физики',
                'description' => 'Учебник по физике для школьников и студентов.',
                'user_id' => 2,
                'discipline_id' => 2,
            ],
            [
                'code' => 'B003',
                'name' => 'Химия: Опыты и Теория',
                'description' => 'Учебник, содержащий теорию и практические работы по химии.',
                'user_id' => 3,
                'discipline_id' => 3,
            ],
            [
                'code' => 'B004',
                'name' => 'Программирование для начинающих',
                'description' => 'Учебник по основам программирования на языке Python.',
                'user_id' => 1,
                'discipline_id' => 4,
            ],
            [
                'code' => 'B005',
                'name' => 'Биология: Структура живых существ',
                'description' => 'Учебник по биологии, изучающий строение живых организмов.',
                'user_id' => 2,
                'discipline_id' => 5,
            ],
            [
                'code' => 'B006',
                'name' => 'История России',
                'description' => 'Учебник по истории России от древности до современности.',
                'user_id' => 3,
                'discipline_id' => 6,
            ],
            [
                'code' => 'B007',
                'name' => 'География мира',
                'description' => 'Учебник по географии, описывающий континенты, страны и их особенности.',
                'user_id' => 1,
                'discipline_id' => 7,
            ],
            [
                'code' => 'B008',
                'name' => 'Литература России',
                'description' => 'Учебник, включающий анализ произведений русской литературы.',
                'user_id' => 2,
                'discipline_id' => 8,
            ],
            [
                'code' => 'B009',
                'name' => 'Основы философии',
                'description' => 'Учебник, вводящий в основные философские концепции и учения.',
                'user_id' => 3,
                'discipline_id' => 9,
            ],
            [
                'code' => 'B010',
                'name' => 'Экономика для начинающих',
                'description' => 'Учебник по основам экономики для школьников и студентов.',
                'user_id' => 1,
                'discipline_id' => 10,
            ],
            [
                'code' => 'B011',
                'name' => 'Право: Основы законодательства',
                'description' => 'Учебник по основам гражданского и уголовного права.',
                'user_id' => 2,
                'discipline_id' => 11,
            ],
            [
                'code' => 'B012',
                'name' => 'Иностранные языки: Английский',
                'description' => 'Учебник для изучающих английский язык с нуля.',
                'user_id' => 3,
                'discipline_id' => 12,
            ],
            [
                'code' => 'B013',
                'name' => 'Основы музыкальной теории',
                'description' => 'Учебник по теории музыки, основам гармонии и ритма.',
                'user_id' => 1,
                'discipline_id' => 13,
            ],
            [
                'code' => 'B014',
                'name' => 'Физкультура: Здоровье и тренировки',
                'description' => 'Учебник по физкультуре, основам здорового образа жизни.',
                'user_id' => 2,
                'discipline_id' => 14,
            ],
        ]);
    }
}
