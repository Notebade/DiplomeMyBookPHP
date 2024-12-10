<?php

namespace App\Http\Controllers;

use App\Modules\Discipline\Models\Discipline;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function disciplineShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Discipline::all();
    }
}
