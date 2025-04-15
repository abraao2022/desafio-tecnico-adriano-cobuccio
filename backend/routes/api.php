<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Middleware\UserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::post('/customers', [CustomerController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    //transações
    Route::post('/transaction/deposit', [TransactionController::class, 'deposit']);
    // Route::post('/transaction/revert', [TransactionController::class, 'revert'])->middleware(UserIsAdmin::class);
    Route::post('/transaction/revert', [TransactionController::class, 'revert']);
    Route::post('/transaction/transfer', [TransactionController::class, 'transfer']);
    Route::get('/transaction/my-transactions', [TransactionController::class, 'index']);
});
