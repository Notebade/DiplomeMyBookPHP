<?php
declare(strict_types=1);

use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\UserController;
use App\Modules\Discipline\Controllers\DisciplineController;
use App\Modules\Media\Controllers\MediaController;
use App\Modules\Subject\Controllers\SubjectsController;
use App\Modules\Test\Controllers\QuestionsController;
use App\Modules\Test\Controllers\TestingController;
use App\Modules\Text\Controllers\TextController;
use App\Modules\Theme\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token();// todo убрать перейти на brear token (мб под самый конец, а пока только так)
});

Route::prefix('/user')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/check', [UserController::class, 'check']);
    });
    Route::prefix('/zov')->group(function () {
        Route::get('', [UserController::class, 'getInvite']);
        Route::post('', [UserController::class, 'invite']);
    });
    Route::post('/register', [UserController::class, 'register']);
    Route::prefix('/test')->group(function () {
        Route::post('', [UserController::class, 'test']);
    });
    Route::post('/logging', [UserController::class, 'logging']);
    Route::prefix('{users:id}')->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('/active', [UserController::class, 'activeUser']);
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
    Route::prefix('{test:id}')->group(function () {
        Route::get('', [TestingController::class, 'show']);
        Route::post('', [TestingController::class, 'update']);
        Route::delete('', [TestingController::class, 'destroy']);
        Route::delete('/questions/clear', [TestingController::class, 'clear']);
    });
    Route::post('', [TestingController::class, 'create']);
});

Route::prefix('/questions')->group(function () {
    Route::prefix('{questions:id}')->group(function () {
        Route::get('', [QuestionsController::class, 'show']);
        Route::post('', [QuestionsController::class, 'update']);
        Route::delete('', [QuestionsController::class, 'destroy']);
    });
    Route::post('', [QuestionsController::class, 'create']);
});
Route::prefix('/groups')->group(function () {
    Route::prefix('{groups:id}')->group(function () {
        Route::get('', [GroupsController::class, 'show']);
        Route::put('', [GroupsController::class, 'update']);
        Route::delete('', [GroupsController::class, 'destroy']);
    });
    Route::post('', [GroupsController::class, 'create']);
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
    Route::get('/questionTypes', [ListController::class, 'questionTypes']);
    Route::get('/userAnswersTypes', [ListController::class, 'userAnswersTypes']);
    Route::post('/media', [ListController::class, 'mediaShows']);
    Route::post('/media', [ListController::class, 'mediaShows']);
    Route::post('/rights', [ListController::class, 'rightsShows']);
    Route::post('/groups', [ListController::class, 'groupsShows']);
    Route::post('/users', [ListController::class, 'usersShows']);
    Route::prefix('/result')->group(function () {
        Route::post('/test', [ListController::class, 'testResults']);
    });
    Route::post('/disciplines', [ListController::class, 'disciplineShows']);
    Route::post('/subjects', [ListController::class, 'subjectShows']);
    Route::post('/themes', [ListController::class, 'themesShows']);
    Route::post('/text', [ListController::class, 'textShows']);
    Route::post('/tests', [ListController::class, 'testsShows']);
    Route::post('/practices', [ListController::class, 'practicesShows']);
});
