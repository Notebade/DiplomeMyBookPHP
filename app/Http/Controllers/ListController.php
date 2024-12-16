<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Theme\Models\Theme;
use App\Text\Models\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ListController extends Controller
{
    public function disciplineShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Discipline::all();
    }

    public function subjectShows(Request $request)
    {
        $data = $this->getDataByRequestSubjects($request);
        $subjects = Subjects::where('discipline_id', $data['disciplineId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        return $subjects->get();
    }

    public function textShows(Request $request)
    {
        $data = $this->getDataByRequestTexts($request);
        $theme = Text::where('theme_id', $data['themeId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        return $theme->get();
    }


    private function getDataByRequestTexts(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'themeId' => 'required|integer',
                'name' => 'nullable|string',
            ]
        )->validate();
    }

    public function themesShows(Request $request)
    {
        $data = $this->getDataByRequestSubjects($request);
        $theme = Theme::where('subject_id', $data['subjectsId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        return $theme->get();
    }


    private function getDataByRequestThemes(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'subjectsId' => 'required|integer',
                'name' => 'nullable|string',
            ]
        )->validate();
    }


    /**
     * @throws ValidationException
     */
    private function getDataByRequestSubjects(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'disciplineId' => 'required|integer',
                'name' => 'nullable|string',
            ]
        )->validate();
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
