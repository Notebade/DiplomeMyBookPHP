<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('test')->insert([
            [
                'theme_id' => 1,
                'user_id' => 1,
                'code' => 'test1',
                'name' => 'тест по алгебре основы и формулы',
            ],
        ]);

        DB::table('question_type')->insert([
            [
                'code' => 'single',
                'name' => 'один вариант ответа',
            ],
            [
                'code' => 'multiple',
                'name' => 'несколько вариантов ответа',
            ],
            [
                'code' => 'textArea',
                'name' => 'введите ответ',
            ],
        ]);

        DB::table('user_answer_type')->insert([
            [
                'code' => 'failed',
                'name' => 'тест завален',
            ],
            [
                'code' => 'success',
                'name' => 'тест пройден',
            ],
            [
                'code' => 'process',
                'name' => 'тест в процессе',
            ],
        ]);

        // Добавляем вопросы
        DB::table('questions')->insert([
            [
                'type_id' => 1, // Тип вопроса: один вариант ответа
                'test_id' => 1, // ID теста
                'text' => 'Что такое переменная в алгебре?',
            ],
            [
                'type_id' => 1, // Тип вопроса: один вариант ответа
                'test_id' => 1, // ID теста
                'text' => 'Решите уравнение: 2x + 3 = 7.',
            ],
            [
                'type_id' => 1, // Тип вопроса: один вариант ответа
                'test_id' => 1, // ID теста
                'text' => 'Какое выражение является результатом раскрытия скобок: (x + 2)(x - 3)?',
            ],
            [
                'type_id' => 1, // Тип вопроса: один вариант ответа
                'test_id' => 1, // ID теста
                'text' => 'Какое из следующих уравнений является квадратным: 2x^2 + 3x + 1 = 0?',
            ],
            [
                'type_id' => 1, // Тип вопроса: один вариант ответа
                'test_id' => 1, // ID теста
                'text' => 'Что такое нулевой элемент множества чисел в алгебре?',
            ],
            // Вопрос с несколькими вариантами ответа
            [
                'type_id' => 2, // Тип вопроса: несколько вариантов ответа
                'test_id' => 1, // ID теста
                'text' => 'Какие из следующих выражений являются многочленами?',
            ],
            // Вопрос, где нужно ввести ответ
            [
                'type_id' => 3, // Тип вопроса: введите ответ
                'test_id' => 1, // ID теста
                'text' => 'Введите решение уравнения: 3x - 5 = 10.',
            ],
        ]);

        // Добавляем ответы
        DB::table('answers')->insert([
            [
                'question_id' => 1, // Вопрос 1
                'text' => 'Число или символ, который используется для обозначения неизвестного значения.',
                'right' => true,
            ],
            [
                'question_id' => 2, // Вопрос 2
                'text' => 'x = 2',
                'right' => true,
            ],
            [
                'question_id' => 3, // Вопрос 3
                'text' => 'x^2 - x - 6',
                'right' => true,
            ],
            [
                'question_id' => 4, // Вопрос 4
                'text' => '2x^2 + 3x + 1 = 0',
                'right' => true,
            ],
            [
                'question_id' => 5, // Вопрос 5
                'text' => 'Число, которое не меняет результат операции (например, 0 для сложения и 1 для умножения).',
                'right' => true,
            ],
            [
                'question_id' => 6, // Вопрос 6 (многократный выбор)
                'text' => 'x^2 + 2x + 1',
                'right' => true,
            ],
            [
                'question_id' => 6, // Вопрос 6 (многократный выбор)
                'text' => '2x + 3',
                'right' => false,
            ],
            [
                'question_id' => 6, // Вопрос 6 (многократный выбор)
                'text' => 'x^2 - 4x + 4',
                'right' => true,
            ],
            [
                'question_id' => 6, // Вопрос 6 (многократный выбор)
                'text' => 'x^3 + 2x^2',
                'right' => false,
            ],
            [
                'question_id' => 7, // Вопрос 7 (ввести ответ)
                'text' => 'x = 5',
                'right' => true,
            ],
        ]);
    }
}
