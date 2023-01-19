<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\KostTipe;
use App\Models\Pendaftaran;
use App\Models\Pengontrak;
use App\Models\Pembayaran;
use App\Models\Pengaduan;
use App\Models\Pemilik;
use App\Models\UsersFcm;
use DB;
use Validator;

class PengontrakController extends Controller
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
            $data = DB::select(DB::raw("SELECT p.id_user as id_user, kt.id as id_kost_jenis, s.name, k.judul, kt.nama_tipe, p.tanggal_masuk
            FROM pengontrak as p
            JOIN kost_tipe as kt on p.id_kost_jenis=kt.id
            JOIN kost as k on kt.id_kost=k.id
            JOIN pemilik as pe on k.id_pemilik=pe.id
            JOIN users as s on p.id_user=s.id
            WHERE k.id_pemilik = '".$id_pemilik."'"));
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pengontrak berhasil ditampilkan";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pengontrak gagal ditampilkan";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);   
    }

    function getByKostTipeAndUser(Request $request)
    {
        $data = Pengontrak::with('user','kost_tipe','kost_tipe.kost','kost_tipe.kost.provinsi','kost_tipe.kost.kabupaten','kost_tipe.kost.kecamatan','kost_tipe.kost.desa','kost_tipe.foto')
            // ->where('id_kost_jenis', $request->id_kost_jenis)
            ->where('id_user', $request->id_user)
            ->first();

        if(!empty($data->id)){
            $data->list_pembayaran = Pembayaran::where('id_user', $request->id_user)->get();
            $data->list_pengaduan = Pengaduan::where('id_user', $request->id_user)->get();
        }

        $code = 200;
        $res['status'] = true;
        $res['message'] = "Detail Kost Saya";
        $res['data'] = $data;

        return response()->json($res, $code); 
    }

    function home(Request $request)
    {
        $where = "WHERE";

        if($request->nama != null){
            if($where=="WHERE"){
                $where .= " judul like '%".strtolower($request->nama)."%'";
            }else{
                $where .= " and judul like '%".strtolower($request->nama)."%'";
            }
        }

        if($request->id_provinsi != null && $request->id_provinsi != 0){
            if($where=="WHERE"){
                $where .= " k.id_provinsi = '".$request->id_provinsi."'";
            }else{
                $where .= " and k.id_provinsi = '".$request->id_provinsi."'";
            }
        }

        if($request->id_kabupaten != null && $request->id_kabupaten != 0){
            if($where=="WHERE"){
                $where .= " k.id_kabupaten = '".$request->id_kabupaten."'";
            }else{
                $where .= " and k.id_kabupaten = '".$request->id_kabupaten."'";
            }
        }

        if($request->id_kecamatan != null && $request->id_kecamatan != 0){
            if($where=="WHERE"){
                $where .= " k.id_kecamatan = '".$request->id_kecamatan."'";
            }else{
                $where .= " and k.id_kecamatan = '".$request->id_kecamatan."'";
            }
        }

        if($request->id_desa != null && $request->id_desa != 0){
            if($where=="WHERE"){
                $where .= " k.id_desa = '".$request->id_desa."'";
            }else{
                $where .= " and k.id_desa = '".$request->id_desa."'";
            }
        }

        if($where=="WHERE"){
            $where = "";
        }

        $data = DB::select(DB::raw("SELECT k.id as id_kost, kt.id as id_kost_tipe, concat(judul, ' - ', nama_tipe) as nama, harga_per_bulan, concat(alamat,', ',nama_desa,', ',nama_kecamatan,', ',nama_kabupaten,', ',nama_provinsi) as alamat, foto
        FROM kost as k
        JOIN kost_tipe as kt on k.id=kt.id_kost
        JOIN kost_foto as kf on kf.id_kost_jenis=kt.id and kf.main_foto=1
        JOIN provinsi as p on p.id=k.id_provinsi
        JOIN kabupaten as k2 on k2.id=k.id_kabupaten
        JOIN kecamatan as k3 on k3.id=k.id_kecamatan
        JOIN desa as d on d.id=k.id_desa
        $where"));

        $code = 200;
        $res['status'] = true;
        $res['message'] = "List Kost";
        $res['data'] = $data;
        return response()->json($res, $code); 
    }

    function detail(Request $request)
    {
        $data = KostTipe::with('kost','kost.provinsi','kost.kabupaten','kost.kecamatan','kost.desa','kost.pemilik','kost.pemilik.user','foto')
            ->where('id', $request->id_kost_tipe)
            ->first();

        $code = 200;
        $res['status'] = true;
        $res['message'] = "Detail Kost";
        $res['data'] = $data;
        return response()->json($res, $code); 
    }

    function pendaftaran(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();

        $input['tanggal_sewa'] = date('Y-m-d');
        
        $fotoKtp = $input['id_user'].'-'.time().'-fotoKtp.'.$request->foto_ktp->extension();  
        $request->foto_ktp->move('images', $fotoKtp);
        $input['foto_ktp'] = url('images').'/'.$fotoKtp;
        $fotoPribadi = $input['id_user'].'-'.time().'-fotoPribadi.'.$request->foto_pribadi->extension();  
        $request->foto_pribadi->move('images', $fotoPribadi);
        $input['foto_pribadi'] = url('images').'/'.$fotoPribadi;
        $fotoKk = $input['id_user'].'-'.time().'-fotoKk.'.$request->foto_kk->extension();  
        $request->foto_kk->move('images', $fotoKk);
        $input['foto_kk'] = url('images').'/'.$fotoKk;

        $validator = Validator::make($input, [
            'id_user' => 'required',
            'id_kost' => 'required',
            'id_kost_stok' => 'required',
            'tanggal_sewa' => 'required',
            'foto_ktp' => 'required',
            'foto_pribadi' => 'required',
            'foto_kk' => 'required',
            'tanggal_mulai' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost = Kost::find($input['id_kost']);
            $input['id_pemilik'] = $kost->id_pemilik;
            
            // Pendaftaran::create($input);

            // insert ke table notif
            $pemilik = Pemilik::find($kost->id_pemilik);
            $this->api->insert_notifikasi($pemilik->id_user, 'Ada Calon Pengontrak Baru!', 'Segera cek data calon pengontrakmu. untuk menerima dia tinggal di kost mu!');
            $token = $this->api->getUsersFcmToken($pemilik->id_user);
            $send_notif = $this->api->send_notification($token, false, 'Ada Calon Pengontrak Baru!', 'Segera cek data calon pengontrakmu. untuk menerima dia tinggal di kost mu!');

            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pendaftaran berhasil diinput";
            $res['token'] = $token;
            $res['send_notif'] = $send_notif;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pendaftaran gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }

    function kost_saya(Request $request)
    {
        try {
            $data = Pengontrak::with('user','kost_tipe','kost_tipe.kost','kost_tipe.kost.provinsi','kost_tipe.kost.kabupaten','kost_tipe.kost.kecamatan','kost_tipe.kost.desa','kost_tipe.foto')
                ->where('id_user', $this->api->getUserLogin())
                ->first();
    
            $data->list_pembayaran = Pembayaran::where('id_user', $this->api->getUserLogin())->get();
            $data->list_pengaduan = Pengaduan::where('id_user', $this->api->getUserLogin())->get();
    
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Detail Kost Saya";
            $res['data'] = $data;
        } catch (\Throwable $th) {
            $code = 404;
            $res['status'] = false;
            $res['message'] = "Anda belum mempunyai kost. silahkan cari kost anda terlebih dahulu";
        }

        return response()->json($res, $code); 
    }

    function submit_pembayaran(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $input['tanggal_bayar'] = date('Y-m-d');
        $input['status'] = 'Menunggu Verifikasi';
        $validator = Validator::make($input, [
            'id_kost' => 'required',
            'id_kost_stok' => 'required',
            'jumlah_bayar' => 'required',
            'nama_rekening' => 'required',
            'nama_bank' => 'required',
            'to_id_bank' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost = Kost::find($input['id_kost']);
            $kost_tipe = KostTipe::find($input['id_kost_stok']);
            $input['id_pemilik'] = $kost->id_pemilik;

            $imageName = 'bukti_bayar-'.time().$input['id_user'].'.'.$request->bukti_bayar->extension();  
            $request->bukti_bayar->move('images', $imageName);
            $input['bukti_bayar'] = url('images').'/'.$imageName;

            if($input['jumlah_bayar']<$kost_tipe->harga_per_bulan){
                $code = 500;
                $res['status'] = false;
                $res['message'] = "Pembayaran tidak mencukupi";
                $res['error'] = null;
                return response()->json($res, $code);
            }

            Pembayaran::create($input);

            // insert ke table notif
            $pemilik = Pemilik::find($kost->id_pemilik);
            $this->api->insert_notifikasi($pemilik->id_user, 'Ada pembayaran dari pengontrak!', 'Segera cek data pembayranmu. untuk memverifikasi apakah bukti pembayarannya valid atau tidak!');
            $token = $this->api->getUsersFcmToken($pemilik->id_user);
            $this->api->send_notification($token, false, 'Ada pembayaran dari pengontrak!', 'Segera cek data pembayranmu. untuk memverifikasi apakah bukti pembayarannya valid atau tidak!');

            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pembayaran berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pembayaran gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }



    function detail_pembayaran(Request $request)
    {
        $data = Pembayaran::with('user','pemilik','kost','kost_tipe','bank')
            ->where('id_user', $this->api->getUserLogin())
            ->first();

        $code = 200;
        $res['status'] = true;
        $res['message'] = "Detail Pembayaran";
        $res['data'] = $data;

        return response()->json($res, $code); 
    }

    function submit_pengaduan(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = $this->api->getUserLogin();
        $input['tanggal'] = date('Y-m-d');
        $input['status'] = 'Menunggu Verifikasi';
        $validator = Validator::make($input, [
            'id_kost' => 'required',
            'id_kost_stok' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $kost = Kost::find($input['id_kost']);
            $kost_tipe = KostTipe::find($input['id_kost_stok']);
            $input['id_pemilik'] = $kost->id_pemilik;

            $imageName = 'foto_pengaduan-'.time().$input['id_user'].'.'.$request->foto_pengaduan->extension();  
            $request->foto_pengaduan->move('images', $imageName);
            $input['foto_pengaduan'] = url('images').'/'.$imageName;

            Pengaduan::create($input);

            // insert ke table notif
            $pemilik = Pemilik::find($kost->id_pemilik);
            $this->api->insert_notifikasi($pemilik->id_user, 'Ada pengaduan dari pengontrak!', 'Segera cek data pengaduanmu. untuk melihat kendala apa yang dialami oleh pengontrak di tempat kostnya!');
            $token = $this->api->getUsersFcmToken($pemilik->id_user);
            $this->api->send_notification($token, false, 'Ada pengaduan dari pengontrak!', 'Segera cek data pengaduanmu. untuk melihat kendala apa yang dialami oleh pengontrak di tempat kostnya!');

            $code = 200;
            $res['status'] = true;
            $res['message'] = "Pengaduan berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Pengaduan gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }



    function detail_pengaduan(Request $request)
    {
        $data = Pengaduan::with('user','pemilik','kost','kost_tipe','pengerjaan')
            ->where('id_user', $this->api->getUserLogin())
            ->first();

        $code = 200;
        $res['status'] = true;
        $res['message'] = "Detail Pengaduan ";
        $res['data'] = $data;

        return response()->json($res, $code); 
    }
}
