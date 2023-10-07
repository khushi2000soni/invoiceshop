<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.reset-password');
});

// Authentication Routes

Route::group(['middleware' => 'guest'], function () {
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('authenticate');
    Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('forgot.password');
    Route::post('/forgot-pass-mail',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password_mail_link');
    Route::get('reset-password/{token}/{email}', [ResetPasswordController::class,'showform'])->name('reset-password');
    Route::post('/reset-password',[ResetPasswordController::class,'resetpass'])->name('reset-new-password');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
});
