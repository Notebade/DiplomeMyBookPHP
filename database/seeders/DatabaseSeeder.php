<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Subject\Models\Subjects;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersAdmin::class,
            DisciplineBase::class,
            SubjectBase::class,
            BaseTheme::class,
            TextBase::class,
            RightsSeeder::class,
            GroupsSeeder::class,
            TestSeeder::class,
        ]);
    }
}
