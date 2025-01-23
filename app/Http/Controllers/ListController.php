<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Discipline\Models\Discipline;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Test\Models\QuestionType;
use App\Modules\Test\Models\Test;
use App\Modules\Test\Models\UserAnswersType;
use App\Modules\Test\Models\UserTest;
use App\Modules\Text\Models\Text;
use App\Modules\Theme\Models\Theme;
use App\Modules\User\Models\Groups;
use App\Modules\User\Models\Rights;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ListController extends Controller
{
    public function disciplineShows(Request $request): iterable
    {
        $data = $request->all();
        $rights = Auth::getUser()->rights()->get()->pluck('code')->toArray();
        if(!empty($data['discipline']['id'])) {
            return Discipline::where('id',$data['discipline']['id'])->get();
        }
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

    public function testsShows(Request $request): mixed
    {
        $rights = Auth::getUser()->rights()->get()->pluck('code')->toArray();
        $data = $this->getDataByRequestTest($request);
        if (empty($data['themeId'])) {
            if(in_array('admin', $rights)) {
                return Test::all();
            }
            if(in_array('teacher', $rights)) {
                return Test::select('test.*')
                    ->leftJoin('theme', 'theme.id', '=', 'test.theme_id')
                    ->leftJoin('subjects', 'theme.subject_id', '=', 'theme.id')
                    ->where('subjects.user_id', Auth::getUser()->id)
                    ->groupBy('test.id')
                    ->get();
            }
            if(in_array('student', $rights) || in_array('parent', $rights)) {
                return Test::select('test.*')
                    ->leftJoin('theme', 'theme.id', '=', 'test.theme_id')
                    ->leftJoin('subjects', 'theme.subject_id', '=', 'theme.id')
                    ->leftJoin('subject_group', 'subject_group.subject_id', '=', 'subjects.id')
                    ->whereIn('subject_group.group_id', Auth::getUser()->groups()->get()->pluck('id'))
                    ->groupBy('test.id')
                    ->get();
            }
        }
        $test = Test::where('theme_id', $data['themeId']);
        if (!empty($data['name'])) {
            //todo фильтр
        }
        return $test->get();
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequestTest(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'themeId' => 'nullable|integer',
            ]
        )->validate();
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

    public function testResults(Request $request)
    {
        $data = $request->all();
        if(!empty($data['test']['id'])) {
            return UserTest::where('test_id', $data['test']['id'])
                ->where('user_id', Auth::getUser()->id)
                ->get();
        }
        return UserTest::where('user_id', Auth::getUser()->id)->get() ?? [];
    }

    public function usersShows(Request $request): array
    {
        $users = [];
        $data = $this->getDataByRequestUsers($request);
        if (array_key_exists('active', $data)) {
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

    public function rightsShows(): \Illuminate\Database\Eloquent\Collection
    {
        return Rights::all();
    }

    public function questionTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return QuestionType::all();
    }

    public function userAnswersTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return UserAnswersType::all();
    }
}
