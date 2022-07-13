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

Route::get('/test', function () {
    return 'test admin';
});

Route::get('/admin/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login_form')->middleware('guest');

Route::post('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'attemptLogin'])->name('admin.login');
