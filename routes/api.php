<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemilikController;

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
Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh', [AuthController::class, 'refresh']);
        Route::get('/profile', [AuthController::class, 'profile']);
        // pemilik
        Route::post('/pemilik', [PemilikController::class, 'save']);
        Route::get('/pemilik/{id}', [PemilikController::class, 'get']);
        Route::post('/pemilik/{id}', [PemilikController::class, 'update']);
    });
});