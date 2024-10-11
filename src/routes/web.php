<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;



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


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/date_attendance', [UserController::class, 'date_attendance']);
    Route::post('/date_attendance', [UserController::class, 'date_attendance']);
    Route::get('/user_attendance', [UserController::class, 'user_attendance']);
    Route::post('/user_attendance', [UserController::class, 'user_attendance']);
    Route::get('/all_users', [UserController::class, 'all_users']);
    Route::post('/all_users', [UserController::class, 'all_users']);
    Route::post('/button_action', [UserController::class, 'select_action'])->name('button.action');

});
