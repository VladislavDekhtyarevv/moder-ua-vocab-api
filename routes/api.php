<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::resource('words', \App\Http\Controllers\WordController::class);
Route::get('/words', [\App\Http\Controllers\WordController::class, 'index']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/words/create', [\App\Http\Controllers\WordController::class, 'create']);
    Route::post('/words', [\App\Http\Controllers\WordController::class, 'store']);
    //Route::get('/words/{word}', [\App\Http\Controllers\WordController::class, 'show']);
    //Route::put('/words/{word}', [\App\Http\Controllers\WordController::class, 'update']);
    //Route::delete('/words/{word}', [\App\Http\Controllers\WordController::class, 'destroy']);

    Route::post('/toggle-like', [\App\Http\Controllers\Api\LikeController::class, 'toggleLike']);
    Route::post('/toggle-dislike', [\App\Http\Controllers\Api\LikeController::class, 'toggleDislike']);
});
