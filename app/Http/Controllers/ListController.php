<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Discipline\Models\Discipline;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function disciplineShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Discipline::all();
    }

    public function usersShows(): array
    {
        $users = [];
        foreach (User::all() as $user) {
            if($user->id == Auth::getUser()->id) {
                continue;
            }
            $users[] = $user;
        }
        return $users;
    }
}
