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

use App\Http\Controllers\RegisterController;
Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register', [RegisterController::class, 'store']);


use App\Http\Controllers\LoginController;

Route::get('login', [LoginController::class, 'login'])->name('login');

Route::post('login', [LoginController::class, 'authenticate']);

Route::get('logout', [LoginController::class, 'logout'])->name('logout');



use App\Http\Controllers\StudentController;

Route::group(['middleware' => ['auth']], function() {
Route::get('welcome', [StudentController::class, 'welcome'])->name('welcome');

});

use App\Http\Controllers\ForgotPasswordController;

Route::get('forget-password', [ForgotPasswordController::class, 'getEmail'])->name('getmail');
Route::post('forget-password', [ForgotPasswordController::class, 'postEmail'])->name('sendmail');

use App\Http\Controllers\ResetPasswordController;

Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword'])->name('resetlink');
Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('resetpassword');
