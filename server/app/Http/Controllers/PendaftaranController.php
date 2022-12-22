<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pengontrak;
use Validator;

class PendaftaranController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function terima(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pendaftaran' => 'required',
            'nomor_kost' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $pendaftaran = Pendaftaran::find($request->id_pendaftaran);
            Pengontrak::create([
                'id_pendaftaran' => $request->id_pendaftaran,
                'nomor_kost' => $request->nomor_kost,
                'id_kost_jenis' => $pendaftaran->id_kost_stok,
                'id_user' => $pendaftaran->id_user,
                'tanggal_masuk' => $pendaftaran->tanggal_mulai
            ]);
            $pendaftaran->update([
                'id_pemilik' => $id_pemilik = $this->api->getPemilikLogin()
            ]);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Terima Pendaftaran berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Terima Pendaftaran gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
