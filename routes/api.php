<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\KostJenisController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\KostTipeController;
use App\Http\Controllers\AlamatController;

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
        
    Route::get('alamat/provinsi', [AlamatController::class,'provinsi']);
    Route::get('alamat/provinsi/{id}/detail', [AlamatController::class,'provinsiById']);
    Route::get('alamat/kabupaten', [AlamatController::class,'kabupaten']);
    Route::get('alamat/kabupaten/{id}', [AlamatController::class,'kabupatenByIdProvinsi']);
    Route::get('alamat/kabupaten/{id}/detail', [AlamatController::class,'kabupatenById']);
    Route::get('alamat/kecamatan', [AlamatController::class,'kecamatan']);
    Route::get('alamat/kecamatan/{id}', [AlamatController::class,'kecamatanByIdKabupaten']);
    Route::get('alamat/kecamatan/{id}/detail', [AlamatController::class,'kecamatanById']);
    Route::get('alamat/desa', [AlamatController::class,'desa']);
    Route::get('alamat/desa/{id}', [AlamatController::class,'desaByIdKecamatan']);
    Route::get('alamat/desa/{id}/detail', [AlamatController::class,'desaById']);
    
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
        // kost jenis
        Route::get('/kost-jenis', [KostJenisController::class, 'all']);
        Route::post('/kost-jenis', [KostJenisController::class, 'save']);
        Route::get('/kost-jenis/{id}', [KostJenisController::class, 'get']);
        Route::post('/kost-jenis/{id}', [KostJenisController::class, 'update']);
        Route::delete('/kost-jenis/{id}', [KostJenisController::class, 'delete']);
        // kost
        Route::get('/kost', [KostController::class, 'all']);
        Route::post('/kost', [KostController::class, 'save']);
        Route::get('/kost/{id}', [KostController::class, 'get']);
        Route::post('/kost/{id}', [KostController::class, 'update']);
        Route::delete('/kost/{id}', [KostController::class, 'delete']);
        // kost tipe
        Route::get('/kost-tipe/find-by-kost/{id}', [KostTipeController::class, 'all']);
        Route::post('/kost-tipe', [KostTipeController::class, 'save']);
        Route::get('/kost-tipe/{id}', [KostTipeController::class, 'get']);
        Route::post('/kost-tipe/{id}', [KostTipeController::class, 'update']);
        Route::delete('/kost-tipe/{id}', [KostTipeController::class, 'delete']);
    });
});