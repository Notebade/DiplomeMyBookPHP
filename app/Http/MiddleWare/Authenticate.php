<?php
declare(strict_types=1);

namespace App\Http\MiddleWare;

use App\Modules\User\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        //todo кастыль для обхода авторизации
        $excludedRoutes = [
           'user/logging' => ['POST'],
           'user/register' => ['POST'],
           'user/zov' => ['GET'],
        ];

        if (in_array($request->path(), array_keys($excludedRoutes))
            && in_array($request->getMethod(), $excludedRoutes[$request->path()])) {
            return $next($request);
        }

        $token = $request->bearerToken();

        if (!$token || empty($this->findUserByData($token))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Auth::login($this->findUserByData($token));

        return parent::handle($request, $next, $guards);
    }

    protected function findUserByData(string $token): ?User
    {
        return User::where('remember_token', $token)->firstOrFail();
    }
}
