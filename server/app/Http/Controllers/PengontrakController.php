<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;

class PengontrakController extends Controller
{

    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function home(Request $request)
    {
        $data = Kost::join('kost_tipe','kost_tipe.id_kost','kost.id');
        $data = $data->offset(20 * $request->offset);
        $data = $data->limit(20);
        $data = $data->get();

        $code = 200;
        $res['status'] = true;
        $res['message'] = "List Kost";
        $res['data'] = $data;
        return response()->json($res, $code); 
    }

    function detail(Request $request)
    {
        $data = Kost::join('kost_tipe','kost_tipe.id_kost','kost.id')
            ->where('kost.id', $request->id_kost)
            ->where('kost_tipe.id', $request->id_kost_tipe)
            ->first();

        $data->foto = KostFoto::where('id_kost_jenis', $request->id_kost_tipe);

        $code = 200;
        $res['status'] = true;
        $res['message'] = "Detail Kost";
        $res['data'] = $data;
        return response()->json($res, $code); 
    }
}
