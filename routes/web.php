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

Route::get('/login', \App\Http\Controllers\LoginController::class)->name('login');
Route::get(
    config('laravel-passwordless-login.login_route'),
    [\App\Http\Controllers\ValidateLoginController::class, 'login']
)->middleware('web')->name(config('laravel-passwordless-login.login_route_name'));
