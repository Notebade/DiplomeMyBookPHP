<?php
declare(strict_types=1);

namespace App\Modules\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Models\Questions;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionsController extends Controller
{
    use Wrapper;

    public function show(Questions $questions): Questions
    {
        return $questions;
    }

    public function update(Questions $questions, Request $request): iterable
    {
        try {
            $validator = $this->requestData($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $questions->fill($validator);
        try {
            $questions->save();
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
            $test = Questions::create($validator);
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $test;
    }

    public function destroy(Questions $questions): array
    {
        try {
            $questions->delete();
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
        if (!empty($data['type'])) {
            $data['type_id'] = $data['type']['id'];
        }
        if (!empty($data['test'])) {
            $data['test_id'] = $data['test']['id'];
        }
        return validator(
            $data,
            [
                'test_id' => 'required|integer',
                'text' => 'required|string',
                'type_id' => 'required|integer',
            ]
        )->validate();
    }
}
