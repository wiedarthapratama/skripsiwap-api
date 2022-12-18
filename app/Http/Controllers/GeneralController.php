<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GeneralController extends Controller
{

    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function dashboard()
    {
        $id_pemilik = $this->api->getPemilikLogin();
        $id_user = $this->api->getUserLogin();
        $res['data']['user'] = DB::select(DB::raw("SELECT count(id_user) as total FROM pengontrak AS p JOIN kost_tipe AS kt ON p.id_kost_jenis=kt.id JOIN kost as k on k.id=kt.id_kost where id_pemilik=$id_pemilik"));
    }
}
