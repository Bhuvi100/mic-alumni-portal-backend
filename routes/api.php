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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'show']);

    Route::patch('/users/{user}/update', [\App\Http\Controllers\UserController::class, 'update']);

    Route::get('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'show']);
    Route::post('projects/{project}/status', [\App\Http\Controllers\ProjectStatusController::class, 'update']);

    Route::get('users/{user}/feedback', [\App\Http\Controllers\FeedbackController::class, 'show']);
    Route::post('users/{user}/feedback', [\App\Http\Controllers\FeedbackController::class, 'update']);

    Route::get('users/{user}/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'show']);
    Route::post('users/{user}/status', [\App\Http\Controllers\ParticipantStatusesController::class, 'update']);

    Route::middleware('admin')->group(function () {
        Route::get('imports',[\App\Http\Controllers\ImportsController::class,'index']);
        Route::post('imports',[\App\Http\Controllers\ImportsController::class,'import']);
    });

    Route::post('/logout', \App\Http\Controllers\LogoutController::class);
});

Route::post('/login', \App\Http\Controllers\LoginController::class);
