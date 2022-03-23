<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/announcements/public', [\App\Http\Controllers\AnnouncementsController::class, 'public_index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('/user/update', [\App\Http\Controllers\UserController::class, 'update']);
    Route::patch('/user/update', [\App\Http\Controllers\UserController::class, 'update']);

    Route::get('projects', [\App\Http\Controllers\ProjectsController::class, 'index']);

    Route::get('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'show']);
    Route::post('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'update']);

    Route::get('projects/{project}/feedback', [\App\Http\Controllers\FeedbackController::class, 'show']);
    Route::post('projects/{project}/feedback', [\App\Http\Controllers\FeedbackController::class, 'update']);

    Route::get('user/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'show']);
    Route::post('user/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'update']);

    Route::get('user/story', [\App\Http\Controllers\StoriesController::class, 'show']);
    Route::post('user/story', [\App\Http\Controllers\StoriesController::class, 'update']);

    Route::middleware('admin')->group(function () {
        Route::get('imports', [\App\Http\Controllers\ImportsController::class, 'index']);
        Route::post('imports', [\App\Http\Controllers\ImportsController::class, 'import']);
        Route::post('imports/sample/download', [\App\Http\Controllers\ImportsController::class, 'download_sample']);
        Route::post('imports/{import}/download', [\App\Http\Controllers\ImportsController::class, 'download'])->name('imports.download');
        Route::resource('announcements', \App\Http\Controllers\AnnouncementsController::class);
        Route::resource('initiatives', \App\Http\Controllers\InitiativesController::class);
        Route::get('stories', [\App\Http\Controllers\StoriesController::class, 'index']);
        Route::post('stories/{story}/update_display', [\App\Http\Controllers\StoriesController::class, 'updateDisplay']);

        Route::get('projects/{project}/users/{user}/feedback', [\App\Http\Controllers\FeedbackController::class, 'show']);

        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::get('users/{user}/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'show']);
        Route::get('users/{user}/story', [\App\Http\Controllers\StoriesController::class, 'show']);
        Route::get('stats', \App\Http\Controllers\StatisticsController::class);
    });

    Route::post('/logout', \App\Http\Controllers\LogoutController::class);
});

Route::post('/login', \App\Http\Controllers\LoginController::class);
Route::get('/announcements/{announcement}', [\App\Http\Controllers\AnnouncementsController::class, 'show']);

