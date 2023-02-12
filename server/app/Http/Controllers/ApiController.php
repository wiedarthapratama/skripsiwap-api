<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\Notifikasi;
use App\Models\UsersFcm;
use DB;

class ApiController extends Controller
{
    function getUserLogin() 
    {
        return auth()->user()->id;
    }

    function getPemilikLogin()
    {
        $pemilik = Pemilik::where('id_user', $this->getUserLogin())->first();
        return $pemilik->id;
    }

    function send_notification($to, $is_subscribe = false, $title = '', $body = '', $intent = '', $param = '', $image = '')
    {
        $curl = curl_init();
        $data = array();

        if (is_array($to)) {
            $ids = array();

            foreach ($to as $id) {
                $ids[] = $id;
            }

            $data['registration_ids'] = $ids;
        } else {
            $data['to'] = (($is_subscribe) ? '/topics/' : '') . $to;
        }

        $data['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';

        $data['data'] = [
            'intent' => $intent,
            'param' => $param,
            // 'sound' => 'notif_cuan.wav',
            // 'image' => $image,
        ];
        $data['notification'] = [
            'title' => $title,
            'body' => $body,
            // 'sound' => 'notif_cuan.wav',
            // 'image' => $image
        ];

        // Android
        $data['android']['priority'] = 'high';
        $data['android']['notification']['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
        $data['android']['image'] = $image;

        // IOS
        $data['apns']['payload']['aps']['content-available'] = true;
        $data['apns']['payload']['aps']['category'] = 'INVITE_CATEGORY';
        $data['apns']['headers']['apns-push-type'] = 'background';
        $data['apns']['headers']['apns-priority'] = 5;
        $data['apns']['headers']['apns-topic'] = 'io.flutter.plugins.firebase.messaging';
        $data['apns']['fcm_options']['image'] = $image;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data, true),
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=".env('AUTH_FIREBASE'),
                "Content-Type: application/json"
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        $res['request'] = $data;

        if ($err || empty($response)) {
            $res['status'] = false;
            $res['code'] = 500;
            $res['message'] = 'Notification not sent';
            $res['firebase_msg'] = $err;
            $res['data'] = $data;
        } else {
            $res['status'] = true;
            $res['code'] = 200;
            $res['message'] = 'Notification has been sent';
            $res['data'] = $response;
        }

        return json_encode($res, true);
    }

    function insert_notifikasi($id_user, $judul, $deskripsi)
    {
        return Notifikasi::create([
            'id_user'=>$id_user,
            'judul'=>$judul,
            'deskripsi'=>$deskripsi,
            'tgl'=>date('Y-m-d H:i:s')
        ]);
    }

    function getUsersFcmToken($id_users)
    {
        $usersFcm = UsersFcm::where('id_user', $id_users)->get();
        $token = [];
        foreach ($usersFcm as $uF) {
            array_push($token, $uF->fcm_token);
        }
        return $token;
    }

    function getUsersFcmTokenMany($id_users)
    {
        $usersFcm = UsersFcm::whereIn('id_user', $id_users)->get();
        $token = [];
        foreach ($usersFcm as $uF) {
            array_push($token, $uF->fcm_token);
        }
        return $token;
    }

    function getDataForNotifPayment()
    {
        try {
            // $day = date('d');
            $day = 8;
            $data = DB::select(DB::raw("
                select *
                from (
                    select id_user, min(tanggal_bayar) as tanggal
                    from pembayaran
                    group by id_user
                ) v 
                where day(tanggal) = '".$day."'
            "));
            $id_users = [];
            foreach ($data as $d) {
                $this->insert_notifikasi($d->id_user, 'Ada Calon Pengontrak Baru!', 'Segera cek data calon pengontrakmu. untuk menerima dia tinggal di kost mu!');
                array_push($id_users, $d->id_user);
            }
            $token = $this->getUsersFcmTokenMany($id_users);
            $send_notif = $this->send_notification($token, false, 'Waktu pembayaran kost sudah tiba!', 'Segera lakukan pembayaran kost! abaikan bila anda sudah membayarnya.');
            $res['status'] = true;
            $res['code'] = 200;
            $res['message'] = 'Notification has been sent';
        } catch (\Throwable $th) {
            $res['status'] = false;
            $res['code'] = 500;
            $res['message'] = 'Notification not sent';
        }

        return response()->json($res, $res['code']);
    }
}
