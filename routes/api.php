<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'checkDevice'], function () {
    Route::controller(LoginController::class)->group(function(){
        Route::post('login', 'login');
        Route::post('forgot-password', 'forgotPassword');
        Route::post('password/verify-otp', 'verifyOtp');
        Route::post('password/reset', 'resetPassword');
    });

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/device/login', [LoginController::class, 'LoginWithPin']);
        Route::post('/logout', [LogoutController::class, 'logout']);

        Route::group(['prefix' => 'customers'], function () {
            Route::get('/index', [CustomerController::class, 'PartyInvoiceList']);
            Route::get('/party-list', [CustomerController::class, 'AllCustomerList']);
            Route::post('/store', [CustomerController::class, 'store']);
            Route::get('/order-details', [CustomerController::class, 'PartyOrderDetail']);
        });
        Route::get('/get-cities', [CustomerController::class, 'AllCities']);
        Route::get('/get-products', [CustomerController::class, 'AllProducts']);

        Route::group(['prefix' => 'orders'], function () {
            Route::post('/store', [OrderController::class, 'store']);
            Route::delete('/{order}', [OrderController::class, 'destroy']);
            Route::put('/{order}', [OrderController::class, 'update']);
        });
    });

});


