<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\KostTipe;

class KostTipeController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function all($id_kost)
    {
        try {
            $data = KostTipe::where('id_kost', $id_kost)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost Tipe berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost Tipe gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $data = KostTipe::with('kost','kost.provinsi','kost.kabupaten','kost.kecamatan','kost.desa','kost.pemilik','kost.pemilik.user','foto')
                ->where('id', $id)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost Tipe berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost Tipe gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function save(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_kost' => 'required',
            'jumlah_kontrakan' => 'required',
            'harga_per_bulan' => 'required',
            'jumlah_ruang' => 'required',
            'luas' => 'required',
            'nama_tipe' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            KostTipe::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost Tipe berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost Tipe gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_kost' => 'required',
            'jumlah_kontrakan' => 'required',
            'harga_per_bulan' => 'required',
            'jumlah_ruang' => 'required',
            'luas' => 'required',
            'nama_tipe' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost = KostTipe::find($id);
            if($kost->id!=null){
                $kost->update($input);
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Kost Tipe berhasil diupdate";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost Tipe gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $data = KostTipe::where('id', $id)
                ->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Kost Tipe berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "Kost Tipe gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost Tipe gagal dihapus";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
