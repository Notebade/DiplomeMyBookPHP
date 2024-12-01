<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MediaController extends Controller
{
    use Wrapper;
    public function show(Media $media): Media
    {
        return $media;
    }

    public function create(Request $request): array
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
            Media::create($validator);
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function update(Request $request, Media $media): array
    {
        try {
            $validator = $this->getDataByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $media->fill($validator);
        try  {
            $media->save();
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function destroy(Media $media): array
    {
        try {
            $media->delete();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    private function getDataByRequest(Request $request): array
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['path'] = $request->file('file')->store('uploads', 'public');
        $data['type'] = $request->file('file')->getMimeType();
        $data['name'] = $request->file('file')->getClientOriginalName();
        return validator(
            $data,
            [
                'parentId' => 'nullable|integer',
                'file' => 'required|max:102400',
                'user_id' => 'nullable|integer',
                'path' => 'required|string',
                'type' => 'required|string',
                'name' => 'required|string',
            ]
        )->validate();
    }
}
