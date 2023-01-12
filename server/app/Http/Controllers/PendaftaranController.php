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

    function all()
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Pendaftaran::with('user','pemilik','pemilik.user','kost','kost_tipe')
                ->where('id_pemilik', $id_pemilik)
                ->whereRaw('created_at != updated_at')
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pendaftaran berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pendaftaran gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Pendaftaran::with('user','pemilik','kost','kost_tipe')
                ->where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pendaftaran berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pendaftaran gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function terima($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_kost' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $pendaftaran = Pendaftaran::find($id);
            Pengontrak::create([
                'id_pendaftaran' => $id,
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
