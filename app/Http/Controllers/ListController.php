<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\User\Models\Rights;
use App\Modules\User\Models\User;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Theme\Models\Theme;
use App\Text\Models\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function Laravel\Prompts\select;

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
        $text = Text::where('theme_id', $data['themeId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        $texts = [];
        foreach ($text->get() as $value) {
            $texts[$value->position] = $value;
        }
        ksort($texts);
        return array_values($texts);
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

    public function themesShows(Request $request): array
    {
        $data = $this->getDataByRequestThemes($request);
        $theme = Theme::where('subject_id', $data['subjectsId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        $themes = [];
        foreach ($theme->get() as $value) {
            $themes[$value->position] = $value;
        }
        ksort($themes);
        return array_values($themes);
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

    /**
     * @throws ValidationException
     */
    private function getDataByRequestUsers(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'rights' => 'nullable|array',
            ]
        )->validate();
    }

    public function usersShows(Request $request): array
    {
        $users = [];
        $data = $this->getDataByRequestUsers($request);
        $usersModels = User::where('active', true)
            ->select('users.*');
        if(!empty($data['rights'])) {
            $usersModels->leftJoin('user_right', 'user_right.user_id', '=', 'users.id');
            $usersModels->whereIn('user_right.right_id', Rights::where('code', $data['rights'])->pluck('id'));
        }
        foreach ($usersModels->get() as $user) {
            if ($user->id == Auth::getUser()->id) {
                continue;
            }
            $users[] = $user;
        }
        return $users;
    }
}
