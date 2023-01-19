<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\UsersFcm;
use Validator;

class FirebaseController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    function test(Request $req)
    {
        try {
            $token = ['cRE5pQFySNqQ-KBHEN9n1S:APA91bFxx1TNjE1YF22CBydsZeMX25R5CQ2XLJirKHkUV9y4F2-yxC-ffdQKCvzAL-peVPcMZYz9sg8F6hnPL6KhuGNYMKQdSTP_TSgzrQQShGz74W6LyWch6EhFpjp8EUQUPuu0nRkR'];;
            $this->api->send_notification($token, false, 'Jangan lupa membayar kost!', 'Sudah hampir tiba waktu untuk membayar kost. jangan sampai lupa!');
            $code = 200;
            $res['status'] = true;
            $res['message'] = "berhasil";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
    
    function saveOrUpdateToken(Request $request)
    {
        $id_user = $this->api->getUserLogin();
        $input = $request->all();
        $input['id_user'] = $id_user;
        $validator = Validator::make($input, [
            'fcm_id' => 'required',
            'fcm_token' => 'required'
        ]);
        if($validator->fails()) {
            $res['status'] = false;
            $res['message'] = $validator->errors()->first();
            return response()->json($res, 400);
        }
        try {
            $users_fcm = UsersFcm::where(['id_user'=>$id_user,'fcm_id'=>$input['fcm_id']])->first();
            if(!empty($users_fcm->id)) {
                UsersFcm::where(['id_user'=>$id_user,'fcm_id'=>$input['fcm_id']])
                    ->update($input);
            }else{
                UsersFcm::create($input);
            }
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Token berhasil diinput";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Token gagal diinput";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code);
    }
}
