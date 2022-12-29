<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
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
            $data = Pembayaran::where('id_pemilik', $id_pemilik)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pembayaran berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pembayaran gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Pembayaran::with('user','pemilik','kost','kost_tipe','bank')
                ->where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pembayaran berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pembayaran gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function terima($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Pembayaran::find($id)->update(['status'=>'Pembayaran Diterima']);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pembayaran berhasil diterima";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pembayaran gagal diterima";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function tolak($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'komentar' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $pembayaran = Pembayaran::find($id);
            $pembayaran->update(['komentar'=>$input['komentar'],'status'=>'Pembayaran Ditolak']);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Tolak Pembayaran berhasil";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Tolak Pembayaran gagal";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
