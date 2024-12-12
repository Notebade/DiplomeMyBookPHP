<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Discipline\Models\Discipline;

class ListController extends Controller
{
    public function disciplineShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Discipline::all();
    }

    public function usersShows(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }
}
