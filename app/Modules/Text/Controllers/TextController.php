<?php
declare(strict_types=1);

namespace App\Modules\Text\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Text\Models\Text;
use App\Modules\Theme\Models\Theme;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TextController extends Controller
{
    use Wrapper;

    public function show(Text $text): Text
    {
        return $text;
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
            $text = [];
            foreach ($validator as $key => $value) {
                $text[$key] = Text::create($value);
                if (!empty($value['media'])) {
                    $mediaIds = array_column($validator['media'], 'id');
                    $text[$key]->media()->sync($mediaIds);
                }
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return $text;
    }

    public function update(Request $request, Text $text): array
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
                $text->fill($value);
                $text->update();
                if (!empty($value['media'])) {
                    $mediaIds = array_column($validator['media'], 'id');
                    $text->media()->sync($mediaIds);
                }
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function destroy(Text $text): array
    {
        try {
            $text->delete();
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
            $value = validator(
                $value,
                [
                    'text' => 'required|string',
                    'media' => 'nullable|array',
                    'position' => 'nullable|integer',
                    'theme_id' => 'required|integer',
                ]
            )->validate();
        }
        return $data;
    }
}
