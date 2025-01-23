<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseTheme extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Математика: Алгебра и Геометрия
            ['code' => 'T001', 'name' => 'Алгебра: Основы и формулы', 'subject_id' => 1, 'position' => 1],
            ['code' => 'T002', 'name' => 'Алгебра: Линейные уравнения', 'subject_id' => 1, 'position' => 2],
            ['code' => 'T003', 'name' => 'Алгебра: Математические функции', 'subject_id' => 1, 'position' => 3],
            ['code' => 'T004', 'name' => 'Алгебра: Неравенства', 'subject_id' => 1, 'position' => 4],
            ['code' => 'T005', 'name' => 'Алгебра: Квадратичные уравнения', 'subject_id' => 1, 'position' => 5],
            ['code' => 'T006', 'name' => 'Алгебра: Полиномиальные функции', 'subject_id' => 1, 'position' => 6],
            ['code' => 'T007', 'name' => 'Алгебра: Матричные операции', 'subject_id' => 1, 'position' => 7],
            ['code' => 'T008', 'name' => 'Алгебра: Логарифмические функции', 'subject_id' => 1, 'position' => 8],
            ['code' => 'T009', 'name' => 'Алгебра: Тригонометрические уравнения', 'subject_id' => 1, 'position' => 9],
            ['code' => 'T010', 'name' => 'Алгебра: Системы уравнений', 'subject_id' => 1, 'position' => 10],

            // Основы физики
            ['code' => 'T011', 'name' => 'Законы физики: Практические задачи', 'subject_id' => 2, 'position' => 1],
            ['code' => 'T012', 'name' => 'Законы физики: Сила и движение', 'subject_id' => 2, 'position' => 2],
            ['code' => 'T013', 'name' => 'Законы физики: Электричество', 'subject_id' => 2, 'position' => 3],
            ['code' => 'T014', 'name' => 'Законы физики: Магнитные поля', 'subject_id' => 2, 'position' => 4],
            ['code' => 'T015', 'name' => 'Законы физики: Закон сохранения энергии', 'subject_id' => 2, 'position' => 5],
            ['code' => 'T016', 'name' => 'Законы физики: Оптика', 'subject_id' => 2, 'position' => 6],
            ['code' => 'T017', 'name' => 'Законы физики: Термодинамика', 'subject_id' => 2, 'position' => 7],
            ['code' => 'T018', 'name' => 'Законы физики: Атомная физика', 'subject_id' => 2, 'position' => 8],
            ['code' => 'T019', 'name' => 'Законы физики: Квантовая механика', 'subject_id' => 2, 'position' => 9],
            ['code' => 'T020', 'name' => 'Законы физики: Ядерные реакции', 'subject_id' => 2, 'position' => 10],

            // Химия: Опыты и Теория
            ['code' => 'T021', 'name' => 'Органическая химия: Теория', 'subject_id' => 3, 'position' => 1],
            ['code' => 'T022', 'name' => 'Органическая химия: Алканы', 'subject_id' => 3, 'position' => 2],
            ['code' => 'T023', 'name' => 'Органическая химия: Алкены', 'subject_id' => 3, 'position' => 3],
            ['code' => 'T024', 'name' => 'Органическая химия: Алканы и алкены', 'subject_id' => 3, 'position' => 4],
            ['code' => 'T025', 'name' => 'Органическая химия: Реакции органических веществ', 'subject_id' => 3, 'position' => 5],
            ['code' => 'T026', 'name' => 'Органическая химия: Спирты', 'subject_id' => 3, 'position' => 6],
            ['code' => 'T027', 'name' => 'Органическая химия: Кислотные группы', 'subject_id' => 3, 'position' => 7],
            ['code' => 'T028', 'name' => 'Органическая химия: Карбоновые кислоты', 'subject_id' => 3, 'position' => 8],
            ['code' => 'T029', 'name' => 'Органическая химия: Нуклеиновые кислоты', 'subject_id' => 3, 'position' => 9],
            ['code' => 'T030', 'name' => 'Органическая химия: Биохимия', 'subject_id' => 3, 'position' => 10],

            // Программирование для начинающих
            ['code' => 'T031', 'name' => 'Основы программирования: Введение', 'subject_id' => 4, 'position' => 1],
            ['code' => 'T032', 'name' => 'Основы программирования: Типы данных', 'subject_id' => 4, 'position' => 2],
            ['code' => 'T033', 'name' => 'Основы программирования: Операторы и циклы', 'subject_id' => 4, 'position' => 3],
            ['code' => 'T034', 'name' => 'Основы программирования: Функции и процедуры', 'subject_id' => 4, 'position' => 4],
            ['code' => 'T035', 'name' => 'Основы программирования: Массивы', 'subject_id' => 4, 'position' => 5],
            ['code' => 'T036', 'name' => 'Основы программирования: Рекурсия', 'subject_id' => 4, 'position' => 6],
            ['code' => 'T037', 'name' => 'Основы программирования: Алгоритмы сортировки', 'subject_id' => 4, 'position' => 7],
            ['code' => 'T038', 'name' => 'Основы программирования: Структуры данных', 'subject_id' => 4, 'position' => 8],
            ['code' => 'T039', 'name' => 'Основы программирования: ООП', 'subject_id' => 4, 'position' => 9],
            ['code' => 'T040', 'name' => 'Основы программирования: Основы Python', 'subject_id' => 4, 'position' => 10],

            // Биология: Структура живых существ
            ['code' => 'T041', 'name' => 'Клеточная биология: Основы', 'subject_id' => 5, 'position' => 1],
            ['code' => 'T042', 'name' => 'Биология: Строение клетки', 'subject_id' => 5, 'position' => 2],
            ['code' => 'T043', 'name' => 'Биология: ДНК и РНК', 'subject_id' => 5, 'position' => 3],
            ['code' => 'T044', 'name' => 'Биология: Митоз и мейоз', 'subject_id' => 5, 'position' => 4],
            ['code' => 'T045', 'name' => 'Биология: Методы исследования клеток', 'subject_id' => 5, 'position' => 5],
            ['code' => 'T046', 'name' => 'Биология: Организмы и их классификация', 'subject_id' => 5, 'position' => 6],
            ['code' => 'T047', 'name' => 'Биология: Физиология человека', 'subject_id' => 5, 'position' => 7],
            ['code' => 'T048', 'name' => 'Биология: Экология', 'subject_id' => 5, 'position' => 8],
            ['code' => 'T049', 'name' => 'Биология: Эволюция', 'subject_id' => 5, 'position' => 9],
            ['code' => 'T050', 'name' => 'Биология: Генетика', 'subject_id' => 5, 'position' => 10],

            // История России
            ['code' => 'T051', 'name' => 'История России: Древняя Русь', 'subject_id' => 6, 'position' => 1],
            ['code' => 'T052', 'name' => 'История России: Киевская Русь', 'subject_id' => 6, 'position' => 2],
            ['code' => 'T053', 'name' => 'История России: Московская Русь', 'subject_id' => 6, 'position' => 3],
            ['code' => 'T054', 'name' => 'История России: Российская империя', 'subject_id' => 6, 'position' => 4],
            ['code' => 'T055', 'name' => 'История России: Петр I и его реформы', 'subject_id' => 6, 'position' => 5],
            ['code' => 'T056', 'name' => 'История России: Екатерина II', 'subject_id' => 6, 'position' => 6],
            ['code' => 'T057', 'name' => 'История России: Революции и войны', 'subject_id' => 6, 'position' => 7],
            ['code' => 'T058', 'name' => 'История России: Советский Союз', 'subject_id' => 6, 'position' => 8],
            ['code' => 'T059', 'name' => 'История России: Российская Федерация', 'subject_id' => 6, 'position' => 9],
            ['code' => 'T060', 'name' => 'История России: Вторая мировая война', 'subject_id' => 6, 'position' => 10],

            // География мира
            ['code' => 'T061', 'name' => 'География: Континенты и океаны', 'subject_id' => 7, 'position' => 1],
            ['code' => 'T062', 'name' => 'География: Африка и Азия', 'subject_id' => 7, 'position' => 2],
            ['code' => 'T063', 'name' => 'География: Европа и Америка', 'subject_id' => 7, 'position' => 3],
            ['code' => 'T064', 'name' => 'География: Климат и природа', 'subject_id' => 7, 'position' => 4],
            ['code' => 'T065', 'name' => 'География: Ресурсы мира', 'subject_id' => 7, 'position' => 5],
            ['code' => 'T066', 'name' => 'География: Экономика и население', 'subject_id' => 7, 'position' => 6],
            ['code' => 'T067', 'name' => 'География: Природные зоны', 'subject_id' => 7, 'position' => 7],
            ['code' => 'T068', 'name' => 'География: Риски и катастрофы', 'subject_id' => 7, 'position' => 8],
            ['code' => 'T069', 'name' => 'География: Транспорт и связи', 'subject_id' => 7, 'position' => 9],
            ['code' => 'T070', 'name' => 'География: Туризм и экологические проблемы', 'subject_id' => 7, 'position' => 10],
            // Литература России
            ['code' => 'T071', 'name' => 'Литература: Русская классика', 'subject_id' => 8, 'position' => 1],
            ['code' => 'T072', 'name' => 'Литература: Поэзия Пушкина', 'subject_id' => 8, 'position' => 2],
            ['code' => 'T073', 'name' => 'Литература: Творчество Гоголя', 'subject_id' => 8, 'position' => 3],
            ['code' => 'T074', 'name' => 'Литература: Романы Достоевского', 'subject_id' => 8, 'position' => 4],
            ['code' => 'T075', 'name' => 'Литература: Чехов и его произведения', 'subject_id' => 8, 'position' => 5],
            ['code' => 'T076', 'name' => 'Литература: Революционные мотивы в литературе', 'subject_id' => 8, 'position' => 6],
            ['code' => 'T077', 'name' => 'Литература: Поэзия серебряного века', 'subject_id' => 8, 'position' => 7],
            ['code' => 'T078', 'name' => 'Литература: Литература советского периода', 'subject_id' => 8, 'position' => 8],
            ['code' => 'T079', 'name' => 'Литература: Современные писатели России', 'subject_id' => 8, 'position' => 9],
            ['code' => 'T080', 'name' => 'Литература: Теория литературы', 'subject_id' => 8, 'position' => 10],

            // Основы философии
            ['code' => 'T081', 'name' => 'Философия: Введение в философию', 'subject_id' => 9, 'position' => 1],
            ['code' => 'T082', 'name' => 'Философия: Античная философия', 'subject_id' => 9, 'position' => 2],
            ['code' => 'T083', 'name' => 'Философия: Средневековая философия', 'subject_id' => 9, 'position' => 3],
            ['code' => 'T084', 'name' => 'Философия: Ренессанс и Просвещение', 'subject_id' => 9, 'position' => 4],
            ['code' => 'T085', 'name' => 'Философия: Немецкая классическая философия', 'subject_id' => 9, 'position' => 5],
            ['code' => 'T086', 'name' => 'Философия: Современные философские течения', 'subject_id' => 9, 'position' => 6],
            ['code' => 'T087', 'name' => 'Философия: Этика и мораль', 'subject_id' => 9, 'position' => 7],
            ['code' => 'T088', 'name' => 'Философия: Логика и эпистемология', 'subject_id' => 9, 'position' => 8],
            ['code' => 'T089', 'name' => 'Философия: Социальная философия', 'subject_id' => 9, 'position' => 9],
            ['code' => 'T090', 'name' => 'Философия: Политическая философия', 'subject_id' => 9, 'position' => 10],

            // Экономика для начинающих
            ['code' => 'T091', 'name' => 'Экономика: Основы экономики', 'subject_id' => 10, 'position' => 1],
            ['code' => 'T092', 'name' => 'Экономика: Рынки и конкуренция', 'subject_id' => 10, 'position' => 2],
            ['code' => 'T093', 'name' => 'Экономика: Влияние правительства на экономику', 'subject_id' => 10, 'position' => 3],
            ['code' => 'T094', 'name' => 'Экономика: Макроэкономика', 'subject_id' => 10, 'position' => 4],
            ['code' => 'T095', 'name' => 'Экономика: Микроэкономика', 'subject_id' => 10, 'position' => 5],
            ['code' => 'T096', 'name' => 'Экономика: Международная торговля', 'subject_id' => 10, 'position' => 6],
            ['code' => 'T097', 'name' => 'Экономика: Финансовые рынки', 'subject_id' => 10, 'position' => 7],
            ['code' => 'T098', 'name' => 'Экономика: Поведение потребителей', 'subject_id' => 10, 'position' => 8],
            ['code' => 'T099', 'name' => 'Экономика: Экономический рост', 'subject_id' => 10, 'position' => 9],
            ['code' => 'T100', 'name' => 'Экономика: Экономическая политика', 'subject_id' => 10, 'position' => 10],

            // Право: Основы законодательства
            ['code' => 'T101', 'name' => 'Право: Конституционное право', 'subject_id' => 11, 'position' => 1],
            ['code' => 'T102', 'name' => 'Право: Гражданское право', 'subject_id' => 11, 'position' => 2],
            ['code' => 'T103', 'name' => 'Право: Уголовное право', 'subject_id' => 11, 'position' => 3],
            ['code' => 'T104', 'name' => 'Право: Трудовое право', 'subject_id' => 11, 'position' => 4],
            ['code' => 'T105', 'name' => 'Право: Семейное право', 'subject_id' => 11, 'position' => 5],
            ['code' => 'T106', 'name' => 'Право: Административное право', 'subject_id' => 11, 'position' => 6],
            ['code' => 'T107', 'name' => 'Право: Международное право', 'subject_id' => 11, 'position' => 7],
            ['code' => 'T108', 'name' => 'Право: Право собственности', 'subject_id' => 11, 'position' => 8],
            ['code' => 'T109', 'name' => 'Право: Право на защиту', 'subject_id' => 11, 'position' => 9],
            ['code' => 'T110', 'name' => 'Право: Судебное разбирательство', 'subject_id' => 11, 'position' => 10],

            // Иностранные языки: Английский
            ['code' => 'T111', 'name' => 'Английский: Основы грамматики', 'subject_id' => 12, 'position' => 1],
            ['code' => 'T112', 'name' => 'Английский: Лексика и идиомы', 'subject_id' => 12, 'position' => 2],
            ['code' => 'T113', 'name' => 'Английский: Произношение', 'subject_id' => 12, 'position' => 3],
            ['code' => 'T114', 'name' => 'Английский: Время и глаголы', 'subject_id' => 12, 'position' => 4],
            ['code' => 'T115', 'name' => 'Английский: Чтение и понимание', 'subject_id' => 12, 'position' => 5],
            ['code' => 'T116', 'name' => 'Английский: Письмо', 'subject_id' => 12, 'position' => 6],
            ['code' => 'T117', 'name' => 'Английский: Разговорные фразы', 'subject_id' => 12, 'position' => 7],
            ['code' => 'T118', 'name' => 'Английский: Английская литература', 'subject_id' => 12, 'position' => 8],
            ['code' => 'T119', 'name' => 'Английский: Занятия с носителями языка', 'subject_id' => 12, 'position' => 9],
            ['code' => 'T120', 'name' => 'Английский: Тестирование и экзамены', 'subject_id' => 12, 'position' => 10],

            // Основы музыкальной теории
            ['code' => 'T121', 'name' => 'Музыка: Основы теории', 'subject_id' => 13, 'position' => 1],
            ['code' => 'T122', 'name' => 'Музыка: Ноты и ритм', 'subject_id' => 13, 'position' => 2],
            ['code' => 'T123', 'name' => 'Музыка: Гармония', 'subject_id' => 13, 'position' => 3],
            ['code' => 'T124', 'name' => 'Музыка: Мелодия и аккорды', 'subject_id' => 13, 'position' => 4],
            ['code' => 'T125', 'name' => 'Музыка: Музыкальные формы', 'subject_id' => 13, 'position' => 5],
            ['code' => 'T126', 'name' => 'Музыка: Тональность', 'subject_id' => 13, 'position' => 6],
            ['code' => 'T127', 'name' => 'Музыка: Интервалы', 'subject_id' => 13, 'position' => 7],
            ['code' => 'T128', 'name' => 'Музыка: Оркестровка', 'subject_id' => 13, 'position' => 8],
            ['code' => 'T129', 'name' => 'Музыка: Теория контрапункта', 'subject_id' => 13, 'position' => 9],
            ['code' => 'T130', 'name' => 'Музыка: Музыкальные инструменты', 'subject_id' => 13, 'position' => 10],

            // Физкультура: Здоровье и тренировки
            ['code' => 'T131', 'name' => 'Физкультура: Основы здоровья', 'subject_id' => 14, 'position' => 1],
            ['code' => 'T132', 'name' => 'Физкультура: Кардионагрузки', 'subject_id' => 14, 'position' => 2],
            ['code' => 'T133', 'name' => 'Физкультура: Силовые тренировки', 'subject_id' => 14, 'position' => 3],
            ['code' => 'T134', 'name' => 'Физкультура: Разминка и растяжка', 'subject_id' => 14, 'position' => 4],
            ['code' => 'T135', 'name' => 'Физкультура: Спортивные игры', 'subject_id' => 14, 'position' => 5],
            ['code' => 'T136', 'name' => 'Физкультура: Питание и спорт', 'subject_id' => 14, 'position' => 6],
            ['code' => 'T137', 'name' => 'Физкультура: Профилактика травм', 'subject_id' => 14, 'position' => 7],
            ['code' => 'T138', 'name' => 'Физкультура: Психология спорта', 'subject_id' => 14, 'position' => 8],
            ['code' => 'T139', 'name' => 'Физкультура: Личный тренер', 'subject_id' => 14, 'position' => 9],
            ['code' => 'T140', 'name' => 'Физкультура: Спортивные достижения', 'subject_id' => 14, 'position' => 10]
        ];
        DB::table('theme')->insert($data);
    }
}
