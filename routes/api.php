<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [ApiController::class, 'index']);
Route::post('posts/{id}/click', [ApiController::class, 'incrementClicks']);
Route::get('stats', [ApiController::class, 'getStats']);
