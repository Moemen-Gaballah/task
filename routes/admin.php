<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;

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



Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login_form')->middleware('guest');

Route::post('/admin/login', [LoginController::class, 'attemptLogin'])->name('admin.login');


Route::group(['prefix'=>'admin','as'=>'admin.', 'middleware' => 'auth:admin'], function()
{

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/list', [TransactionController::class, 'getTransactions'])->name('transactions.list');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/list', [UserController::class, 'getUsers'])->name('users.list');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.transactions.index');
    Route::get('/reports/list', [ReportController::class, 'getTransactions'])->name('reports.transactions.list');

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs.index');


});
