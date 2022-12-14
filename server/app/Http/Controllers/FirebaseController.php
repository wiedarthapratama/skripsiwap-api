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

    function test()
    {
        $token = ["eyn3KdP2RTKgE_p5xxdKz6:APA91bHYv26XkFs8t06vwayzX_1RRluVvsppGQw3IfKfsUjvsZ79RumQbQR_vEyNSnL6gK9o1pLEBcEpwSIu8MEp1sxUa1VeX-D9XiJoX2Vw8B2c0OQ0H6hDLY0CdtfZuRNzXwVu8IV3"];
        return $this->api->send_notification($token, false, 'Pemberitahuan!', 'Segera Checkout pesananmu, ada produk yang sudah habis batas waktu booked');
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
