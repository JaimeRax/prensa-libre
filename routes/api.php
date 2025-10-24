<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/news', [NewsController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('auth/login', [AuthController::class, 'logout']);

    Route::get('/categories/{id}/news', [NewsController::class, 'byCategory']);
    Route::get('/news/{id}', [NewsController::class, 'show']);
    Route::get('/news/{id}/recommended', [NewsController::class, 'recommended']);
});
