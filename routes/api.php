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
    Route::get('/user', function (Request $request) {
        return ['user' => $request->user()];
    });
    Route::patch('/users/{user}/update', [\App\Http\Controllers\UserController::class, 'update']);
});

Route::post('/login', \App\Http\Controllers\LoginController::class);
