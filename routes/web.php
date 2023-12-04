<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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


// Authentication Routes

Route::group(['middleware' => 'guest'], function () {
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('authenticate');
    Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('forgot.password');
    Route::post('/forgot-pass-mail',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password_mail_link');
    Route::get('reset-password/{token}/{email}', [ResetPasswordController::class,'showform'])->name('resetPassword');
    Route::post('/reset-password',[ResetPasswordController::class,'resetpass'])->name('reset-new-password');

});

Route::middleware(['auth','PreventBackHistory'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::resource('/roles',RoleController::class);
    Route::get('/profiles',[UserController::class,'showprofile'])->name('user.profile');
    Route::post('/profile-update', [UserController::class,'updateprofile'])->name('profile.update');
    Route::post('/profile-image', [UserController::class,'updateprofileImage'])->name('profile-image.update');
    Route::get('/change-password',[UserController::class,'showchangepassform'])->name('user.change-password');
    Route::post('/change-password',[UserController::class,'updatePassword'])->name('reset-password');
    Route::resource('/address',AddressController::class);
    Route::get('/address-printView',[AddressController::class,'printView'])->name('address.print');
    Route::get('address-export',[AddressController::class,'export'])->name('address.export');

    Route::resource('/categories',CategoryController::class);
    Route::get('/categories-printView',[CategoryController::class,'printView'])->name('categories.print');

    Route::resource('/staff',UserController::class);
    Route::get('/staff/password/{id}',[UserController::class,'staffpassword'])->name('staff.password');
    Route::put('/staff/password/{id}',[UserController::class,'staffUpdatePass'])->name('staff.change-password');

    Route::resource('/customers',CustomerController::class);
    Route::get('/customers/index/{address_id?}',[CustomerController::class,'index'])->name('customer.index');

    Route::get('/phone-book',[CustomerController::class,'showPhoneBook'])->name('showPhoneBook');
    Route::resource('/products',ProductController::class);
    Route::get('/products/product-list/{category_id}',[ProductController::class,'ProductListOfCategory'])->name('ProductListOfCategory');

    Route::resource('/device',DeviceController::class);
    Route::resource('/orders',OrderController::class);
    Route::get('/get-orders/{type?}', [OrderController::class,'getTypeOrder'])->name('orders.getTypeOrder');
    Route::get('/orders/{order}/generate-pdf',[OrderController::class,'generatePdf'])->name('orders.generate-pdf');
    Route::get('/print-pdf/{order}/{type?}',[OrderController::class,'printPDF'])->name('orders.print-pdf');
    Route::get('/share-email/{order}',[OrderController::class,'shareEmail'])->name('orders.share-email');
    Route::get('/share-whatsapp/{order}',[OrderController::class,'shareWhatsApp'])->name('orders.share-whatsapp');
    Route::get('/reports',[ReportController::class,'index'])->name('reports');
    Route::get('/fetch-report-data', [ReportController::class,'fetchReportData'])->name('fetchReportData');
    Route::get('/getSoldProducts', [ReportController::class,'getSoldProducts'])->name('getSoldProducts');
    Route::get('/settings/{tab?}',[SettingController::class,'index'])->name('settings');
    Route::post('/settings/update',[SettingController::class,'update'])->name('settings.update');
});
