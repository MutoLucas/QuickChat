<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\verifyAuth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LobbyController;

Route::get('/', [AuthController::class, 'showAuth'])->name('auth.index');
Route::get('/lobby/{id?}', [LobbyController::class, 'index'])->name('lobby.index')->middleware(verifyAuth::class);

Route::post('/auth', [AuthController::class,'authUser'])->name('auth.auth');
Route::get('/receiveToken/{email}', [AuthController::class, 'showReceiveToken'])->name('auth.receive.token');
Route::post('/verifyToken', [AuthController::class,'verifyToken'])->name('auth.verify.token');
Route::get('/resendToken/{email}', [AuthController::class,'resendToken'])->name('auth.resend.token');
Route::get('/logout', [AuthController::class, 'logoutUser'])->name('auth.logout');
