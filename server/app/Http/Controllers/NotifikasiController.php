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
}