<?php
declare(strict_types=1);

namespace App\Http\MiddleWare;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            Auth::login($this->findUserByRequest($request));
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage(),], 401);
        }

        return parent::handle($request, $next, $guards);
    }

    protected function findUserByRequest(Request $request): User
    {
        //todo перйти на bearer token
        //$token = $request->bearerToken();
        $userId = $request->header('userId');
        if (!empty($userId)) {
            $user = $this->findUserByData((int)$userId);
        } else {
            $user = $this->findUserByData(3);//зайти как гость
        }

        //$user->update(['token' => $token]);
        return $user;
    }

    protected function findUserByData(int $id): ?User
    {
        if (!empty($id)) {
            $data = [
                'id' => $id,
                'login' => Str::random(16),
                'first_name' => Str::random(16),
                'last_name' => Str::random(16),
                'middle_name' => Str::random(16),
                'email' => Str::random(16),
                'password' => Str::random(16),
            ];

            return User::firstOrCreate(['id' => $data['id'],], $data);
        }

        return null;
    }
}
