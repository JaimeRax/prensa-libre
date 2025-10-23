<?php

use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/news', [NewsController::class, 'index']);
Route::get('/categories/{id}/news', [NewsController::class, 'byCategory']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/news/{id}/recommended', [NewsController::class, 'recommended']);
