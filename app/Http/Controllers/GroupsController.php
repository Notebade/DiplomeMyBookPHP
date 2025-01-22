<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Test\Models\Questions;
use App\Modules\User\Models\Groups;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GroupsController extends Controller
{
    use Wrapper;

    public function show(Groups $groups): Groups
    {
        return $groups;
    }

    public function update(Groups $groups, Request $request): iterable
    {
        try {
            $validator = $this->requestData($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $groups->fill($validator);
        try {
            $groups->update();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function create(Request $request): Questions|array
    {
        try {
            $validator = $this->requestData($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try {
            $group = Groups::create($validator);
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $group;
    }

    public function destroy(Groups $groups): array
    {
        try {
            $groups->delete();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    /**
     * @throws ValidationException
     */
    private function requestData(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'code' => 'required|string',
                'name' => 'required|string',
            ]
        )->validate();
    }
}
