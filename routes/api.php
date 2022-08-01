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

Route::get('chartData', \App\Http\Controllers\LandingStatistics::class);
Route::get('chartYesOrNoData', \App\Http\Controllers\LandingYesorNoStatistics::class);

Route::get('/announcements/public', [\App\Http\Controllers\AnnouncementsController::class, 'public_index']);
Route::get('/stories/public', [\App\Http\Controllers\StoriesController::class, 'public_home']);
Route::get('/stories/public/index/{display}', [\App\Http\Controllers\StoriesController::class, 'public_index']);
Route::get('/stories/public/{story}', [\App\Http\Controllers\StoriesController::class, 'public_show']);

Route::middleware('auth:sanctum')->group(function () {

  

    Route::get('/user', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('/user/update', [\App\Http\Controllers\UserController::class, 'update']);
    Route::patch('/user/update', [\App\Http\Controllers\UserController::class, 'update']);

    Route::get('projects', [\App\Http\Controllers\ProjectsController::class, 'index']);

    Route::get('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'show']);
    Route::post('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'update']);

    Route::get('users/feedback', [\App\Http\Controllers\FeedbackController::class, 'show']);
    Route::post('users/feedback', [\App\Http\Controllers\FeedbackController::class, 'update']);

    Route::get('status', [\App\Http\Controllers\ParticipantStatusesController::class, 'index'])->name('status.index');
    Route::post('status', [\App\Http\Controllers\ParticipantStatusesController::class, 'store'])->name('status.store');
    Route::post('status/{status}', [\App\Http\Controllers\ParticipantStatusesController::class, 'update'])->name('status.update');

    Route::get('user/stories', [\App\Http\Controllers\StoriesController::class, 'show']);
    Route::post('user/stories', [\App\Http\Controllers\StoriesController::class, 'store']);
    Route::post('user/stories/{story}', [\App\Http\Controllers\StoriesController::class, 'update']);

    Route::middleware('admin')->group(function () {
        Route::get('imports', [\App\Http\Controllers\ImportsController::class, 'index']);
        Route::post('imports', [\App\Http\Controllers\ImportsController::class, 'import']);
        Route::post('imports/sample/download', [\App\Http\Controllers\ImportsController::class, 'download_sample']);
        Route::post('imports/{import}/download', [\App\Http\Controllers\ImportsController::class, 'download'])->name('imports.download');
        Route::resource('announcements', \App\Http\Controllers\AnnouncementsController::class);
        Route::get('initiatives/{initiative}/stats', [\App\Http\Controllers\InitiativesController::class, 'getStats']);
        Route::resource('initiatives', \App\Http\Controllers\InitiativesController::class);

        Route::get('stories', [\App\Http\Controllers\StoriesController::class, 'index']);
        Route::get('stories/archived', [\App\Http\Controllers\StoriesController::class, 'archived_index']);
        Route::post('stories/{story}/update_display', [\App\Http\Controllers\StoriesController::class, 'updateDisplay']);
        Route::post('stories/export', [\App\Http\Controllers\StoriesController::class, 'export']);

        Route::get('feedbacks', [\App\Http\Controllers\FeedbackController::class, 'index']);
        Route::get('users/{user}/feedback', [\App\Http\Controllers\FeedbackController::class, 'show']);
        Route::post('feedbacks/export', [\App\Http\Controllers\FeedbackController::class, 'export']);

        Route::get('other-ideas', [\App\Http\Controllers\ParticipantStatusesController::class, 'admin_index']);
        Route::get('hackathon-ideas', [\App\Http\Controllers\ProjectStatusController::class, 'index']);

        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('users/export', [\App\Http\Controllers\UserController::class, 'exportData']);
        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::get('users/{user}/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'show']);
        Route::get('users/{user}/stories', [\App\Http\Controllers\StoriesController::class, 'show']);
        Route::get('stats', \App\Http\Controllers\StatisticsController::class);
    });

    Route::post('/logout', \App\Http\Controllers\LogoutController::class);
});

Route::post('/login', \App\Http\Controllers\LoginController::class);
Route::get('/announcements/{announcement}', [\App\Http\Controllers\AnnouncementsController::class, 'show']);

Route::get('/test', function () {
    return new \App\Mail\MagicLoginMail('google.com');
});
