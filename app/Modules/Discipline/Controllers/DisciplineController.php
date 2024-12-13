<?php
declare(strict_types=1);

namespace App\Modules\Discipline\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Discipline\Models\Discipline;
use App\Wrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DisciplineController extends Controller
{
    use Wrapper;

    public function show(Discipline $discipline): array
    {
        return $discipline->jsonSerialize();
    }

    public function create(Request $request): array|Discipline
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
           $discipline = Discipline::create($validator);
            if (!empty($validator['authors'])) {
                $authorIds = array_column($validator['authors'], 'id');
                $discipline->authors()->sync($authorIds);
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return $discipline;
    }

    public function update(Request $request, Discipline $discipline): array
    {
        try {
            $validator = $this->getDataByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $discipline->fill($validator);
        try  {
            $discipline->save();
            if (!empty($validator['authors'])) {
                $authorIds = array_column($validator['authors'], 'id');
                $discipline->authors()->sync($authorIds);
            }
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function destroy(Discipline $discipline): array
    {
        try {
            $discipline->delete();
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
        $data['media_id'] = $data['media']['id'] ?? null;
        return validator(
            $data,
            [
                'code' => 'required|string',
                'description' => 'nullable|string',
                'name' => 'required|string',
                'media_id' => 'nullable|integer',
                'user_id' => 'required|integer',
                'authors' => 'nullable|array',
            ]
        )->validate();
    }
}
