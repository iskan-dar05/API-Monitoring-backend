<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyController;
use App\Http\Middleware\LogApiRequests;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::any('/send-request', [ProxyController::class, 'handle'])
    ->middleware(['auth:sanctum', LogApiRequests::class]);
Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'metrics']);

Route::get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
