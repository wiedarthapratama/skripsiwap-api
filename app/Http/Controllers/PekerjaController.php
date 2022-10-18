<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Pekerja;

class PekerjaController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function all()
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = Pekerja::with('user')
                ->where('id_user', $id_user)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pekerja berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pekerja gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = Pekerja::with('user')
                ->where('id', $id)
                ->where('id_user', $id_user)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pekerja berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pekerja gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function save(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $validator = Validator::make($input, [
            'nama' => 'required',
            'nohp' => 'required',
            'id_user' => 'required|unique:pekerja',
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
            Pekerja::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pekerja berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pekerja gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $validator = Validator::make($input, [
            'nama' => 'required',
            'nohp' => 'required',
            'id_user' => 'required|unique:pekerja,id_user,'.$input['id_user'],
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
            $pekerja = Pekerja::find($id);
            if($pekerja->id!=null){
                if($pekerja->id_user==$input['id_user']){
                    $pekerja->update($input);
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "Pekerja berhasil diupdate";
                }else{
                    $code = 404;
                    $res['status'] = false;
                    $res['message'] = "Pekerja berhasil diupdate";        
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pekerja gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = Pekerja::with('user')
                ->where('id', $id)
                ->where('id_user', $id_user)
                ->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Pekerja berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "Pekerja gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pekerja gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
