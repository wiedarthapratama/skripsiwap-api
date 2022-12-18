<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pengontrak;

class PendaftaranController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function save(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        
        $fotoKtp = $input['id_user'].'-'.time().'-fotoKtp.'.$request->foto_ktp->extension();  
        $request->foto_ktp->move(public_path('images'), $fotoKtp);
        $input['foto_ktp'] = url('images').'/'.$fotoKtp;
        $fotoPribadi = $input['id_user'].'-'.time().'-fotoPribadi.'.$request->foto_pribadi->extension();  
        $request->foto_pribadi->move(public_path('images'), $fotoPribadi);
        $input['foto_pribadi'] = url('images').'/'.$fotoPribadi;
        $fotoKk = $input['id_user'].'-'.time().'-fotoKk.'.$request->foto_kk->extension();  
        $request->foto_kk->move(public_path('images'), $fotoKk);
        $input['foto_kk'] = url('images').'/'.$fotoKk;

        $validator = Validator::make($input, [
            'id_user' => 'required',
            'id_kost' => 'required',
            'id_kost_stok' => 'required',
            'tanggal_sewa' => 'required',
            'foto_ktp' => 'required',
            'foto_pribadi' => 'required',
            'foto_kk' => 'required',
            'durasi_sewa' => 'required',
            'tanggal_mulai' => 'required',
            'jumlah_bayar' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            Pendaftaran::create($input);
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pendaftaran berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pendaftaran gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function terima(Request $request)
    {
        $input = $request->all();
        $input['id_pemilik'] = $this->api->getPemilikLogin();
        $input['tanggal_masuk'] = date('Y-m-d');

        $validator = Validator::make($input, [
            'id_pemilik' => 'required',
            'nomor_kost' => 'required',
            'id_kost_jenis' => 'required',
            'id_user' => 'required',
            'id_pendaftaran' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            Pendaftaran::find($input['id_pendaftaran'])->update([
                'id_pemilik' => $input['id_pemilik']
            ]);
            Pengontrak::input($input];
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Terima Pendaftaran berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Terima Pendaftaran gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
