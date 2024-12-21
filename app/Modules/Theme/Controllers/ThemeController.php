<?php
declare(strict_types=1);

namespace App\Modules\Theme\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Subject\Models\Subjects;
use App\Modules\Theme\Models\Theme;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ThemeController extends Controller
{
    use Wrapper;

    public function show(Theme $theme): Theme
    {
        return $theme;
    }

    public function lastPosition(Request $request): int
    {
        $data = $request->all();
        $subjects = Subjects::where('id', $data['subjectId'] ?? null)->first();
        $position = 0;
        foreach ($subjects->themes as $theme) {
            if($theme->position > $position) {
                $position = $theme->position;
            }
        }
        return ++$position;
    }

    public function create(Request $request): array
    {
        try {
            $validator = $this->getDataByRequest([$request->all()]);
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

    public function update(Request $request, Theme $theme): array
    {
        try {
            $validator = $this->getDataByRequest([$request->all()]);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            foreach ($validator as $value) {
                $themes = Theme::where('subject_id', $value['subject_id'])
                ->where('position', '>', $value['position'])->get();
                foreach ($themes as $item) {
                    $theme->update(['position' => $item->position + 1]);
                }
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
    private function getDataByRequest(array $data): array
    {
        foreach ($data as &$value) {
            $value['parent_id'] = $value['theme']['id'] ?? null;
            $value['subject_id'] = $value['subject']['id'] ?? null;
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
