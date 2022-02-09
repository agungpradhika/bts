<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoppingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/user', [App\Http\Controllers\AuthController::class, 'user'])->middleware('jwt.verify');

Route::resource('shopping', App\Http\Controllers\ShoppingController::class)->middleware('jwt.verify');

Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
