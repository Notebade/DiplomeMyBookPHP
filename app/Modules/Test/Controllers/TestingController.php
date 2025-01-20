<?php
declare(strict_types=1);

namespace App\Modules\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Models\Test;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TestingController extends Controller
{

    use Wrapper;

    public function show(Test $test): Test
    {
        return $test;
    }

    public function update(Test $test, Request $request): Test|array
    {
        try {
            $validator = $this->requestData($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $test->fill($validator);
        try {
            $test->update();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $test;
    }

    public function create(Request $request): Test|array
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
            $test = Test::create($validator);
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $test;
    }

    public function destroy(Test $test): array
    {
        try {
            $test->delete();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function clear(Test $test): Test|array
    {
        try {
            $test->questions()->delete();
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
        $data['user_id'] = Auth::user()->id;
        if (!empty($data['theme']['id'])) {
            $data['theme_id'] = $data['theme']['id'];
        }
        return validator(
            $data,
            [
                'theme_id' => 'nullable|integer',
                'code' => 'required|string',
                'name' => 'nullable|string',
                'user_id' => 'required|integer',
            ]
        )->validate();
    }
}
