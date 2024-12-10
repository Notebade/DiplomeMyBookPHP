<?php
declare(strict_types=1);

use App\Http\MiddleWare\Authenticate;
use App\Http\MiddleWare\HandleCors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //todo тут нужно авторизацию сделать по токену
        $middleware->use([
            Authenticate::class,
            HandleCors::class,
        ]);
        $middleware->validateCsrfTokens(
            except: ['*',]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
