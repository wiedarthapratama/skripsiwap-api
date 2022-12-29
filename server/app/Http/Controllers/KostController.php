<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Kost;

class KostController extends Controller
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
            $data = Kost::where('id_pemilik', $id_pemilik)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Kost::where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function save(Request $request)
    {
        $input = $request->all();
        $input['id_pemilik'] = $this->api->getPemilikLogin();
        $validator = Validator::make($input, [
            'judul' => 'required',
            'deskripsi' => 'required',
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'alamat' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            Kost::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Kost berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $input['id_pemilik'] = $this->api->getPemilikLogin();
        $validator = Validator::make($input, [
            'judul' => 'required',
            'deskripsi' => 'required',
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'alamat' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost = Kost::find($id);
            if($kost->id!=null){
                if($kost->id_pemilik==$input['id_pemilik']){
                    $kost->update($input);
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "Kost berhasil diupdate";
                }else{
                    $code = 404;
                    $res['status'] = false;
                    $res['message'] = "Kost berhasil diupdate";        
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Kost::where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Kost berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "Kost gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Kost gagal dihapus";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
