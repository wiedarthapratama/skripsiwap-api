<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
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
            $data = Notifikasi::where('id_user', $id_user)
                ->get();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Notifikasi berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Notifikasi gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function count_notif()
    {
        try {
            $id_user = $this->api->getUserLogin();
            $data = Notifikasi::where('id_user', $id_user)
                ->count();
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Notifikasi berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Notifikasi gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function read_notif($id)
    {
        try {
            $id_user = $this->api->getUserLogin();
            $update = Notifikasi::where('id_user', $id_user)
                ->where('id', $id)
                ->update(['is_read'=>1]);
            if($update){
                $code = 200;
                $res['status'] = true;
                $res['message'] = "Notifikasi berhasil diread";
            }else{
                $code = 404;
                $res['status'] = false;
                $res['message'] = "Notifikasi gagal diread";
            }
        } catch (\Throwable $th) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Notifikasi gagal dimuat";
        }
        return response()->json($res, $code);   
    }
}