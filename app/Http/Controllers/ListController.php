<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\User\Models\Groups;
use App\Modules\User\Models\Rights;
use App\Modules\User\Models\User;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Theme\Models\Theme;
use App\Text\Models\Text;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ListController extends Controller
{
    public function disciplineShows(): iterable
    {
        $rights = Auth::getUser()->rights()->get()->pluck('code')->toArray();
        if(in_array('admin', $rights)) {
            return Discipline::all();
        }
        if(in_array('teacher', $rights)) {
            return Discipline::select('disciplines.*')
                ->leftJoin('author_discipline', 'author_discipline.discipline_id', '=', 'disciplines.id')
                ->where(function ($query) {
                    $query->where('author_discipline.user_id', Auth::getUser()->id)
                        ->orWhere('disciplines.user_id', Auth::getUser()->id);
                })
                ->get();
        }
        if(in_array('student', $rights) || in_array('parent', $rights)) {
            return Discipline::select('disciplines.*')
                ->leftJoin('discipline_groups', 'discipline_groups.discipline_id', '=', 'disciplines.id')
                ->whereIn('discipline_groups.group_id', Auth::getUser()->groups()->get()->pluck('id'))
                ->get();
        }
        return Discipline::all();
    }

    public function subjectShows(Request $request)
    {
        $data = $this->getDataByRequestSubjects($request);
        $subjects = Subjects::where('discipline_id', $data['disciplineId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }

        $rights = Auth::getUser()->rights()->get()->pluck('code')->toArray();
        if(in_array('admin', $rights)) {
            return $subjects->get();
        }
        if(in_array('teacher', $rights)) {
            return $subjects->select('subjects.*')
                ->where('subjects.user_id', Auth::getUser()->id)
                ->get();
        }
        if(in_array('student', $rights) || in_array('parent', $rights)) {
            return $subjects->select('subjects.*')
                ->leftJoin('subject_group', 'subject_group.subject_id', '=', 'subjects.id')
                ->whereIn('subject_group.group_id', Auth::getUser()->groups()->get()->pluck('id'))
                ->get();
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
                'active' => 'nullable|boolean',
            ]
        )->validate();
    }

    public function usersShows(Request $request): array
    {
        $users = [];
        $data = $this->getDataByRequestUsers($request);
        if (!empty($data['active'])) {
            $usersModels = User::where('active', $data['active']);
        } else {
            $usersModels = User::where('active', true);
        }
            $usersModels->select('users.*');
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

    public function groupsShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Groups::all();
    }
}
