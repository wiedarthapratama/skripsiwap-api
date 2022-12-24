<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Pengerjaan;

class PengaduanController extends Controller
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
            $data = Pengaduan::where('id_pemilik', $id_pemilik)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pengaduan berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pengaduan gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Pengaduan::with('user','pemilik','kost','kost_tipe','pengerjaan')
                ->where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pengaduan berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pengaduan gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function kirim_pekerja($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_pekerja' => 'required',
            'durasi_pengerjaan' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $pembayaran = Pengaduan::find($id);
            $pembayaran->update(['status'=>'Pengaduan Diterima']);
            Pengerjaan::create([
                'id_pengaduan' => $id,
                'id_pekerja' => $input['id_pekerja'],
                'durasi_pengerjaan' => $input['durasi_pengerjaan'],
                'status' => 'Pengaduan Diterima'
            ]);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kirim Pekerja berhasil";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kirim Pekerja gagal";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
