<?php
declare(strict_types=1);
namespace App\Http\MiddleWare;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Разрешаем все источники (можно заменить на конкретные домены)
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Можно заменить '*' на конкретный домен

        // Разрешаем все методы: GET, POST, PUT, DELETE, OPTIONS
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        // Разрешаем все заголовки
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        // Разрешаем отправку Cookies (если нужно)
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
