<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\User\Models\Invite;
use App\Modules\User\Models\User;
use App\Wrapper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    use Wrapper;
    public function index(User $user): User
    {
        return $user;
    }

    public function activeUser(User $user): array
    {
        $user->active = true;
        try  {
            $user->save();
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function getInvite(Request $request)
    {
        return Invite::where('code', $request->get('code'))
            ->where('date_end', '>=', Carbon::now())
            ->firstOrFail();
    }

    public function invite(Request $request): array
    {
        try {
            $validator = $this->getDataByRequestInvite($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            Invite::create($validator);
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function register(Request $request): array
    {
        try {
            $validator = $this->getDataByRequestRegister($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try  {
            User::create($validator);
        } catch (\Exception $e){
            return self::failed($e->getMessage());
        }
        return self::success();
    }


    public function logging(Request $request): mixed
    {
        try {
            $validator = $this->getDataByRequestLogging($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $user = User::where('login', $validator['login'])
            ->where('password', $validator['password'])
            ->where('active', true)
            ->firstOrFail();
        $token = Str::random(40);
        $user->update(['remember_token' => $token]);
        return $user->jsonSerialize(true);
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequestLogging(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'login' => 'required|string',
                'password' => 'required|string',
            ]
        )->validate();
    }


    /**
     * @throws ValidationException
     */
    private function getDataByRequestRegister(Request $request): array
    {
        $data = $request->all();
        $data['first_name'] = $data['firstName'];
        $data['last_name'] = $data['lastName'];
        $data['middle_name'] = $data['middleName'];
        if (empty($data['active'])) {
            $data['active'] = false;
        }
        return validator(
            $data,
            [
                'login' => 'required|string',
                'password' => 'required|string',
                'rights' => 'required|array',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email',
                'middle_name' => 'required|string',
                'active' => 'required|boolean',
            ]
        )->validate();
    }


    /**
     * @throws ValidationException
     */
    private function getDataByRequestInvite(Request $request): array
    {
        $data = $request->all();
        $data['user_id'] = Auth::getUser()->id;
        $data['date_end'] = Carbon::create($data['dateEnd']);
        $data['info'] = json_encode($data['info']);
        $data['code'] = hash('sha256', 'User' . Auth::getUser()->id . Carbon::now()->toDateTimeString());
        return validator(
            $data,
            [
                'info' => 'required|string',
                'date_end' => 'required',
                'user_id' => 'required|integer',
                'code' => 'required|string',
            ]
        )->validate();
    }
}
