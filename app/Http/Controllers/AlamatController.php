<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;

class AlamatController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function provinsi()
    {
        $data = Provinsi::all();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Provinsi";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function provinsiById($id)
    {
        $data = Provinsi::find($id);
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Provinsi";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kabupaten()
    {
        $data = Kabupaten::all();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kabupaten";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kabupatenByIdProvinsi($id)
    {
        $data = Kabupaten::where('id_provinsi', $id)->get();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kabupaten";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kabupatenById($id)
    {
        $data = Kabupaten::find($id);
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kabupaten";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kecamatan()
    {
        $data = Kecamatan::all();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kecamatan";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kecamatanByIdKabupaten($id)
    {
        $data = Kecamatan::where('id_kabupaten', $id)->get();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kecamatan";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function kecamatanById($id)
    {
        $data = Kecamatan::find($id);
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Kecamatan";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function desa()
    {
        $data = Desa::all();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Desa";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function desaByIdKecamatan($id)
    {
        $data = Desa::where('id_kecamatan', $id)->get();
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Desa";
        $res['data'] = $data;
        return response()->json($res, $code);
    }

    function desaById($id)
    {
        $data = Desa::find($id);
        $code = 200;
        $res['status'] = true;
        $res['message'] = "Data Desa";
        $res['data'] = $data;
        return response()->json($res, $code);
    }
}
