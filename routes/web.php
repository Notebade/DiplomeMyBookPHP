<?php
declare(strict_types=1);

use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PracticController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token();// todo убрать перейти на brear token (мб под самый конец, а пока только так)
});

Route::prefix('/user')->group(function () {
    Route::prefix('{users:id}')->group(function () {
        Route::get('', [UserController::class, 'index']);
    });
});

Route::prefix('/media')->group(function () {
    Route::prefix('{media:id}')->group(function () {
        Route::get('', [MediaController::class, 'show']);
        Route::post('', [MediaController::class, 'update']);
        Route::delete('', [MediaController::class, 'destroy']);
    });
    Route::post('', [MediaController::class, 'create']);
});

Route::prefix('/test')->group(function () {
    Route::get('/{Test:id}', [TestingController::class, 'show']);
});

Route::prefix('/discipline')->group(function () {
    Route::get('/{Discipline:id}', [DisciplineController::class, 'show']);
});

Route::prefix('/practice')->group(function () {
    Route::get('/{Practice:id}', [PracticController::class, 'show']);
});
