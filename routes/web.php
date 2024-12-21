<?php
declare(strict_types=1);

use App\Http\Controllers\ListController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UserController;
use App\Modules\Discipline\Controllers\DisciplineController;
use App\Modules\Media\Controllers\MediaController;
use App\Modules\Subject\Controllers\SubjectsController;
use App\Modules\Theme\Controllers\ThemeController;
use App\Text\Controllers\TextController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token();// todo убрать перейти на brear token (мб под самый конец, а пока только так)
});

Route::prefix('/user')->group(function () {
    Route::post('/logging', [UserController::class, 'logging']);
    Route::prefix('{users:id}')->group(function () {
        Route::get('', [UserController::class, 'index']);
    });
});

Route::prefix('/media')->group(function () {
    Route::prefix('{media:id}')->group(function () {
        Route::get('', [MediaController::class, 'show']);
        Route::post('', [MediaController::class, 'update']);//put к сожанеию фотки не принемаем перешел на post
        Route::delete('', [MediaController::class, 'destroy']);
    });
    Route::post('', [MediaController::class, 'create']);
    Route::post('/many', [MediaController::class, 'createMany']);
});

Route::prefix('/test')->group(function () {
    Route::get('/{Test:id}', [TestingController::class, 'show']);
});

Route::prefix('/discipline')->group(function () {
    Route::prefix('{discipline:id}')->group(function () {
        Route::get('', [DisciplineController::class, 'show']);
        Route::put('', [DisciplineController::class, 'update']);
        Route::delete('', [DisciplineController::class, 'destroy']);
    });
    Route::post('', [DisciplineController::class, 'create']);
});

Route::prefix('/subject')->group(function () {
    Route::prefix('{subjects:id}')->group(function () {
        Route::get('', [SubjectsController::class, 'show']);
        Route::put('', [SubjectsController::class, 'update']);
        Route::delete('', [SubjectsController::class, 'destroy']);
    });
    Route::post('', [SubjectsController::class, 'create']);
});

Route::prefix('/theme')->group(function () {
    Route::prefix('{theme:id}')->group(function () {
        Route::get('', [ThemeController::class, 'show']);
        Route::put('', [ThemeController::class, 'update']);
        Route::delete('', [ThemeController::class, 'destroy']);
    });
    Route::post('/lastPosition', [ThemeController::class, 'lastPosition']);
    Route::post('', [ThemeController::class, 'create']);
        Route::post('/many', [ThemeController::class, 'createMany']);
});

Route::prefix('/text')->group(function () {
    Route::prefix('{text:id}')->group(function () {
        Route::get('', [TextController::class, 'show']);
        Route::put('', [TextController::class, 'update']);
        Route::delete('', [TextController::class, 'destroy']);
    });
    Route::post('', [TextController::class, 'create']);
});


Route::prefix('/practice')->group(function () {
    Route::get('/{Practice:id}', [PracticeController::class, 'show']);
});



Route::prefix('/list')->group(function () {
    Route::post('/media', [ListController::class, 'mediaShows']);
    Route::post('/users', [ListController::class, 'usersShows']);
    Route::post('/disciplines', [ListController::class, 'disciplineShows']);
    Route::post('/subjects', [ListController::class, 'subjectShows']);
    Route::post('/themes', [ListController::class, 'themesShows']);
    Route::post('/text', [ListController::class, 'textShows']);
    Route::post('/tests', [ListController::class, 'testsShows']);
    Route::post('/practices', [ListController::class, 'practicesShows']);
});
