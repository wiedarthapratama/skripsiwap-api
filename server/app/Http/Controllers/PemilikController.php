<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Pemilik;

class PemilikController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function get($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = Pemilik::with('user')
                ->where('id', $id)
                ->where('id_user', $id_user)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pemilik berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pemilik gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function save(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $validator = Validator::make($input, [
            'id_user' => 'required|unique:pemilik',
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'alamat' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            Pemilik::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pemilik berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pemilik gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $validator = Validator::make($input, [
            'id_user' => 'required|unique:pemilik,id_user,'.$input['id_user'],
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'alamat' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $pemilik = Pemilik::find($id);
            if($pemilik->id!=null){
                if($pemilik->id_user==$input['id_user']){
                    $pemilik->update($input);
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "Pemilik berhasil diupdate";
                }else{
                    $code = 404;
                    $res['status'] = false;
                    $res['message'] = "Pemilik berhasil diupdate";        
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pemilik gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
