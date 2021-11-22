<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', \App\Http\Controllers\LoginController::class);
Route::get(
    config('laravel-passwordless-login.login_route').'/{uid}',
    [\App\Http\Controllers\ValidateLoginController::class, 'login']
)->middleware('web')->name(config('laravel-passwordless-login.login_route_name'));

Route::get('/test', function () {
   return response()->make('<form method="post" action="/test" enctype="multipart/form-data"> {{ csrf() }} <input name="file" type="file"><input type="submit"></form>');
});

Route::post('/test', [\App\Http\Controllers\ImportsController::class, 'import']);