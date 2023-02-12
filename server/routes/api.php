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
use App\Http\Controllers\PengontrakController;
use App\Http\Controllers\KostFotoController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ApiController;

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
Route::group(['middleware' => ['api','apikey']], function($router) {
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

    // pengontrak
    Route::post('/pengontrak/home', [PengontrakController::class, 'home']);
    Route::post('/pengontrak/kost-detail', [PengontrakController::class, 'detail']);
    // ini harusnya login
    Route::post('/pengontrak/pendaftaran', [PengontrakController::class, 'pendaftaran']);
    Route::get('/pengontrak/kost-saya', [PengontrakController::class, 'kost_saya']);
    // pembayaran
    Route::post('/pengontrak/submit-pembayaran', [PengontrakController::class, 'submit_pembayaran']);
    Route::get('/pengontrak/pembayaran/detail/{id}', [PengontrakController::class, 'detail_pembayaran']);
    Route::post('/pengontrak/submit-pengaduan', [PengontrakController::class, 'submit_pengaduan']);
    Route::get('/pengontrak/pengaduan/detail/{id}', [PengontrakController::class, 'detail_pengaduan']);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh', [AuthController::class, 'refresh']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/profile/update', [ProfileController::class, 'update']);
        Route::post('/profile/password', [ProfileController::class, 'password']);
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
        // kost foto
        Route::post('/kost-foto', [KostFotoController::class, 'save']);
        Route::post('/kost-foto/{id}', [KostFotoController::class, 'update']);
        Route::delete('/kost-foto/{id}', [KostFotoController::class, 'delete']);
        // pendaftaran
        Route::get('/pendaftaran', [PendaftaranController::class, 'all']);
        Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'get']);
        Route::post('/pendaftaran/terima/{id}', [PendaftaranController::class, 'terima']);
        // bank
        Route::get('/bank', [BankController::class, 'all']);
        Route::post('/bank', [BankController::class, 'save']);
        Route::get('/bank/{id}', [BankController::class, 'get']);
        Route::post('/bank/{id}', [BankController::class, 'update']);
        Route::delete('/bank/{id}', [BankController::class, 'delete']);
        Route::get('/bank/id-pemilik/{id}', [BankController::class, 'getByIdPemilik']);
        // pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'all']);
        Route::get('/pembayaran/{id}', [PembayaranController::class, 'get']);
        Route::get('/pembayaran/terima/{id}', [PembayaranController::class, 'terima']);
        Route::post('/pembayaran/tolak/{id}', [PembayaranController::class, 'tolak']);
        // pengaduan
        Route::get('/pengaduan', [PengaduanController::class, 'all']);
        Route::get('/pengaduan/{id}', [PengaduanController::class, 'get']);
        Route::post('/pengaduan/kirim-pekerja/{id}', [PengaduanController::class, 'kirim_pekerja']);
        // pengontrak
        Route::get('/pengontrak', [PengontrakController::class, 'all']);
        Route::post('/pengontrak/get-by-kosttipe-and-user', [PengontrakController::class, 'getByKostTipeAndUser']);

        Route::post('/firebase/create-or-update-token', [FirebaseController::class, 'saveOrUpdateToken']);

        Route::get('/notifikasi', [NotifikasiController::class, 'all']);
        Route::get('/notifikasi/count', [NotifikasiController::class, 'count_notif']);
        Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'read_notif']);
    });

    Route::post('/firebase/test', [FirebaseController::class, 'test']);
    Route::get('/cronjob', [ApiController::class, 'getDataForNotifPayment']);
});