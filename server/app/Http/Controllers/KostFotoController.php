<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\KostFoto;

class KostFotoController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function save(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_kost_jenis' => 'required',
            'main_foto' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $imageName = 'kostfoto-'.time().$input['id_kost_jenis'].'.'.$request->foto->extension();  
            $request->foto->move('images', $imageName);
            $input['foto'] = url('images').'/'.$imageName;
            if($input['main_foto']==1){
                KostFoto::where('id_kost_jenis', $input['id_kost_jenis'])->update(['main_foto'=>0]);
            }
            KostFoto::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "KostFoto berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostFoto gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_kost_jenis' => 'required',
            'main_foto' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost_jenis = KostFoto::find($id);
            if($kost_jenis->id!=null){
                $imageName = 'kostfoto-'.time().$input['id_kost_jenis'].'.'.$request->foto->extension();  
                $request->foto->move('images', $imageName);
                $input['foto'] = url('images').'/'.$imageName;

                if($input['main_foto']==1){
                    KostFoto::where('id_kost_jenis', $input['id_kost_jenis'])->update(['main_foto'=>0]);
                }
                $kost_jenis->update($input);

                $code = 200;
                $res['status'] = true;
                $res['message'] = "KostFoto berhasil diupdate";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostFoto gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $data = KostFoto::where('id', $id)->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "KostFoto berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "KostFoto gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "KostFoto gagal dihapus";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
