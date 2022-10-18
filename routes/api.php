<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\KostJenisController;

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
        // pekerja
        Route::get('/pekerja', [PekerjaController::class, 'all']);
        Route::post('/pekerja', [PekerjaController::class, 'save']);
        Route::get('/pekerja/{id}', [PekerjaController::class, 'get']);
        Route::post('/pekerja/{id}', [PekerjaController::class, 'update']);
        Route::delete('/pekerja/{id}', [PekerjaController::class, 'delete']);
        // pekerja
        Route::get('/kost-jenis', [KostJenisController::class, 'all']);
        Route::post('/kost-jenis', [KostJenisController::class, 'save']);
        Route::get('/kost-jenis/{id}', [KostJenisController::class, 'get']);
        Route::post('/kost-jenis/{id}', [KostJenisController::class, 'update']);
        Route::delete('/kost-jenis/{id}', [KostJenisController::class, 'delete']);
    });
});