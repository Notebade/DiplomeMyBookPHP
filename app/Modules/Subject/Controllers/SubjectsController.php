<?php
declare(strict_types=1);

namespace App\Modules\Subject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Subject\Models\Subjects;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SubjectsController extends Controller
{
    use Wrapper;

    public function show(Subjects $subjects): Subjects
    {
        return $subjects;
    }

    public function create(Request $request): array|Subjects
    {
        try {
            $validator = $this->getDataByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            $subjects = Subjects::create($validator);
            if (!empty($validator['groups'])) {
                $groupsIds = array_column($validator['groups'], 'id');
                $subjects->groups()->sync($groupsIds);
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return $subjects;
    }

    public function update(Request $request, Subjects $subjects): array
    {
        try {
            $validator = $this->getDataByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $subjects->fill($validator);
        try  {
            $subjects->save();
            if (!empty($validator['groups'])) {
                $groupsIds = array_column($validator['groups'], 'id');
                $subjects->groups()->sync($groupsIds);
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function destroy(Subjects $subjects): array
    {
        try {
            $subjects->delete();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequest(Request $request): array
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['discipline_id'] = $data['discipline']['id'] ?? null;
        $data['media_id'] = $data['media']['id'] ?? null;
        return validator(
            $data,
            [
                'code' => 'required|string',
                'description' => 'nullable|string',
                'name' => 'required|string',
                'media_id' => 'nullable|integer',
                'discipline_id' => 'required|integer',
                'user_id' => 'required|integer',
                'groups' => 'nullable|array',
            ]
        )->validate();
    }
}
