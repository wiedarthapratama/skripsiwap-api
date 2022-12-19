<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\KostJenis;

class KostJenisController extends Controller
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
            $data = KostJenis::with('user')
                ->where('id_user', $id_user)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "KostJenis berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostJenis gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = KostJenis::with('user')
                ->where('id', $id)
                ->where('id_user', $id_user)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "KostJenis berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostJenis gagal ditampilkan";
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $imageName = $input['id_user'].'-'.time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $input['foto'] = url('images').'/'.$imageName;

            KostJenis::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "KostJenis berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostJenis gagal diinput";
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $kost_jenis = KostJenis::find($id);
            if($kost_jenis->id!=null){
                if($kost_jenis->id_user==$input['id_user']){
                    $imageName = $input['id_user'].'-'.time().'.'.$request->image->extension();  
                    $request->image->move(public_path('images'), $imageName);
                    $input['foto'] = url('images').'/'.$imageName;

                    $kost_jenis->update($input);
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "KostJenis berhasil diupdate";
                }else{
                    $code = 404;
                    $res['status'] = false;
                    $res['message'] = "KostJenis berhasil diupdate";        
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostJenis gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = KostJenis::with('user')
                ->where('id', $id)
                ->where('id_user', $id_user)
                ->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "KostJenis berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "KostJenis gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostJenis gagal dihapus";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
