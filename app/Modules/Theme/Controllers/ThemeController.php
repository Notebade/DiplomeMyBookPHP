<?php

namespace App\Modules\Theme\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Theme\Models\Theme;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ThemeController extends Controller
{
    use Wrapper;

    public function show(Theme $theme): Theme
    {
        return $theme;
    }

    public function create(Request $request, Subjects $subjects): array
    {
        try {
            $validator = $this->getDataByRequest($request, $subjects);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            $themes = [];
            foreach ($validator as $value) {
                $themes[] = Theme::create($value);
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return $themes;
    }

    public function update(Request $request, Subjects $subjects, Theme $theme): array
    {
        try {
            $validator = $this->getDataByRequest($request, $subjects);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            foreach ($validator as $value) {
                $theme->fill($value);
                $theme->save();
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function destroy(Theme $theme): array
    {
        try {
            $theme->delete();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequest(Request $request, Subjects $subjects): array
    {
        $data = $request->all();
        foreach ($data as &$value) {
            $value['parent_id'] = $value['theme']['id'] ?? null;
            $value['subject_id'] = $subjects?->id;
            $value = validator(
                $value,
                [
                    'code' => 'required|string',
                    'name' => 'required|string',
                    'parent_id' => 'nullable|integer',
                    'position' => 'required|integer',
                    'subject_id' => 'required|integer',
                ]
            )->validate();
        }
        return $data;
    }
}
