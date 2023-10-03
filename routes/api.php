<?php

use App\Http\Controllers\account\CreateAccountController;
use App\Http\Controllers\account\FetchAccountBalanceController;
use App\Http\Controllers\account\FetchAccountHistoryController;
use App\Http\Controllers\customer\CreateCustomerController;
use App\Http\Controllers\security\LoginController;
use App\Http\Controllers\security\LogOutController;
use App\Http\Controllers\security\RegistrationController;
use App\Http\Controllers\transaction\CreateTransactionController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['api.key', 'cors', 'force.json']], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/registration', [RegistrationController::class, 'registration']);
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LogOutController::class, 'logout']);
    });

    Route::group(['middleware' => ['authenticate']], function () {
        Route::group(['prefix' => 'customer'], function () {
            Route::post('/create', [CreateCustomerController::class, 'create']);
        });

        Route::group(['prefix' => 'account'], function () {
            Route::post('/create', [CreateAccountController::class, 'create']);
            Route::get('/{account_id}/balance', [FetchAccountBalanceController::class, 'balance']);
            Route::get('/{account_id}/history', [FetchAccountHistoryController::class, 'history']);
        });

        Route::group(['prefix' => 'transaction'], function () {
            Route::post('/', [CreateTransactionController::class, 'transaction']);
        });
    });

});
