<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
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
            $data = Bank::where('id_pemilik', $id_pemilik)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Bank berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function get($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Bank::where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->first();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Bank berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function getByIdPemilik($id)
    {
        try {
            $data = Bank::where('id_pemilik', $id)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Bank berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function save(Request $request)
    {
        $input = $request->all();
        $input['id_pemilik'] = $this->api->getPemilikLogin();
        $validator = Validator::make($input, [
            'nama_bank' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            Bank::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Bank berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function update(Request $request, $id)
    {
        $input = $request->all();
        $input['id_pemilik'] = $this->api->getPemilikLogin();
        $validator = Validator::make($input, [
            'nama_bank' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $Bank = Bank::find($id);
            if($Bank->id!=null){
                if($Bank->id_pemilik==$input['id_pemilik']){
                    $Bank->update($input);
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "Bank berhasil diupdate";
                }else{
                    $code = 404;
                    $res['status'] = false;
                    $res['message'] = "Bank berhasil diupdate";        
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    function delete($id)
    {
        try {
            $id_pemilik = $this->api->getPemilikLogin();
            $data = Bank::where('id', $id)
                ->where('id_pemilik', $id_pemilik)
                ->delete();
            if($data){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Bank berhasil dihapus";
            }else{
                $code = 500;
                $res['status'] = false;
                $res['message'] = "Bank gagal dihapus";
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Bank gagal dihapus";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }
}
