<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyController;
use App\Http\Middleware\LogApiRequests;



Route::any('/send-request', [ProxyController::class, 'handle'])->middleware(LogApiRequests::class);
