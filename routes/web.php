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

Route::group(['middleware' => ['auth','preventBackHistory']], function() {
Route::get('welcome', [StudentController::class, 'welcome'])->name('welcome');

});

use App\Http\Controllers\ForgotPasswordController;

Route::get('forget-password', [ForgotPasswordController::class, 'getEmail'])->name('getmail');
Route::post('forget-password', [ForgotPasswordController::class, 'postEmail'])->name('sendmail');

use App\Http\Controllers\ResetPasswordController;

Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword'])->name('resetlink');
Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('resetpassword');


use App\Http\Controllers\AdminController;

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

use App\Http\Controllers\AjaxStudentController;

Route::group(['prefix' => 'admin','middleware' => ['auth.admin','preventBackHistory']], function ()
{
	Route::get('home', [AdminController::class, 'home'])->name('admin.home');
	Route::get('getAjaxStudentList', [AjaxStudentController::class, 'index'])->name('student.list');

	Route::get('ajaxStudentView/{id}', [AjaxStudentController::class, 'view'])->name('student.view');
	Route::get('ajaxStudentMassDelete', [AjaxStudentController::class, 'massDelete'])->name('student.deleteall');
	Route::get('ajaxStudentDelete/{id}', [AjaxStudentController::class, 'delete'])->name('student.delete');
});