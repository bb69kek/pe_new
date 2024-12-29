<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\HaltController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PayoutController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\AccessTokenController;

use App\Http\Controllers\API\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\Auth\RegisteredUserController;

// use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
// use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




// Fortify::routes();

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
// Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');


// Login a user and issue Sanctum token
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('asset', AssetController::class)->only(['index', 'store', 'destroy']);

    Route::resource('halt', HaltController::class)->only(['index', 'store', 'destroy']);
    Route::post('/halt/stop/{halt}', [HaltController::class, 'stop']);

    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::post('/users/changePassword', [UserController::class, 'changePassword']);
    Route::post('/users/notifications', [UserController::class, 'notifications']);

    Route::resource('payout', PayoutController::class)->only(['index', 'store', 'destroy']);
    Route::resource('wallet', WalletController::class)->only(['index', 'store', 'destroy']);
    Route::post('/wallet/default/{wallet}', [WalletController::class, 'setDefault']);

    Route::resource('accessToken', AccessTokenController::class)->only(['index', 'store', 'destroy']);

    Route::get('/getuser', [UserController::class, 'getUser']);
    Route::get('/get-qrcode', [UserController::class, 'getQRCode']);
    Route::post('/verify-totp', [UserController::class, 'verifyTOTP']);
    Route::get('/disable2FA', [UserController::class, 'disable2FA']);
});

