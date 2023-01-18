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
            $token = ['eyn3KdP2RTKgE_p5xxdKz6:APA91bHYv26XkFs8t06vwayzX_1RRluVvsppGQw3IfKfsUjvsZ79RumQbQR_vEyNSnL6gK9o1pLEBcEpwSIu8MEp1sxUa1VeX-D9XiJoX2Vw8B2c0OQ0H6hDLY0CdtfZuRNzXwVu8IV3',
            'eyn3KdP2RTKgE_p5xxdKz6:APA91bHYv26XkFs8t06vwayzX_1RRluVvsppGQw3IfKfsUjvsZ79RumQbQR_vEyNSnL6gK9o1pLEBcEpwSIu8MEp1sxUa1VeX-D9XiJoX2Vw8B2c0OQ0H6hDLY0CdtfZuRNzXwVu8IV3',
            'eDVGLEAuQFKKqR4o3lpjM7:APA91bGMVlz_UvjpOWxc4PpqHihWaRAKFZiRGFQ8bRqjm1kplLSBbIDwdTSWCv0L_ieC2KpFPvFLzm-qK9MNZMsd2obSFYRUPGaNqEf4ycAFL5tx4XnK3VrkMgwXFbwIDiLbkbaKzQJi',
            'fC8MzC86QXiVvCVDL9nCnV:APA91bHKZu0X0UHT92CxtCoBq4t9fn96ASLkjjwkt_IK-SYu_4EJ-mt84e4RbgaJ9yk6G_cWTTe3KTOqqnIIEPe99B5MCXIRhejXZcw8VY_M2ylExl5T420pEAgROUZDXvocjpH0Jo7x',
            'eqp3BiJeRgumYpyhviPsre:APA91bG1C7yYaQ-sPROawuCl7MbOBP4djxCXmHrPQM1LnyoMwxxiA1sLW9ZI3XzUT0M8g8bXO26kRxgDWZGMk0G9Nft3bfTR_QWJ4-pg-7kS4U5Z4aGdJ1imBS2oGKTzGxW9j-Yjxw_o',
            'ckL4EfYxQ-S0dOUwwPXhNq:APA91bGpfto3U-ljMHKcFkzK8lVL4btqRvj02cwAPAQOwxLw7EyTpxeLlTUucljg7L0gZOAPlMWvP4I1Xx-6L-wv0wXNN_O9Bvj6KmRMP3leJxhJMy7FWwpMm9x2FI7GGI3qzNwzDhi7',
            'fX-iMgp3RTmifJzCq0h6Dz:APA91bGd8bLPp1AU1RknvZHBeCljTGmHo-fMufucH8N0HKTVgoTpiLbkwgLIWNh8MuAOj-ZL1qTLvJxtHHKoDnQMdsBuL1zG5n6FJOiqdMCsIfX08HiJHCdL2gh1Lv2jeYHWd5XQS4gR',
            'eooOTVWnSrmk28NPw8fokM:APA91bEFXWKUID8U3Qyqsd6If6cPL4Hnmr9VpUGe2XtcVteIw2C8Y0mUBTnMmPYZT-TYJVDbDngHEcJZaM8Z03OXTqNWx5B0HfZsw1Dlt8RjbPhHULDmL8hOeq3JrwfOhAscnbCmpPLM',
            'd7u6fCZoSAaHD_TmvmjYb_:APA91bE-wlashFUyCbf_An9AyhzT8gQ1LG8QBFy_T-JfcNGSUUbFe2Qxa4IAI3Ys02fS2z1VADfYoKfU0XoPYZrD5acSOAsKzFmr11QZFb6F_uOXVAMJP_6vwnqdmK6ZsKMSK0AonRl4',
            'cRE5pQFySNqQ-KBHEN9n1S:APA91bFxx1TNjE1YF22CBydsZeMX25R5CQ2XLJirKHkUV9y4F2-yxC-ffdQKCvzAL-peVPcMZYz9sg8F6hnPL6KhuGNYMKQdSTP_TSgzrQQShGz74W6LyWch6EhFpjp8EUQUPuu0nRkR',
            'cWnvYsLsRXiwsRd1cq8f4O:APA91bEvO3hUDokR2imk8eNaxHDBzMB3DK5n5yAZKDuVjwkSBgVsdFaGurKhh5y-K7jrjK2iwhvXzIT4KQyU-0ucB2SdS7JEhUdc-sNVYP2XqU8wFm0I5lf1X04NppPswmxCYvoKXtGu',
            'dkESHEiRSACsXgnNIsSd9F:APA91bE7fEHss-CFMnSdFru2XDhXnDfID6s1mwuGiCNpsnAHfXW25Ce4zllZujC1S2pu6fnS0iutCOFH0yFyc0rfnziCsYXPSEBdQtEamBY-lAqLxG2UGqqXGFGPcQsvKmRQ9Rr7I3Pg',
            'fICl9hxGTgeFl3LdePbivA:APA91bEKER6dR3wwtJ-j3R3GsjJ8lKDnDQrsSc5I_Ymxsege_3hieYmS00ziUXEF7ID9FV3TmgVcd3GGIXm4dnXHKRPP60spIIhCu2ZP2FgLnkTfyeaKTVSiW1BO3xwEwwyZ3c8U5cCS',
            'dkESHEiRSACsXgnNIsSd9F:APA91bE7fEHss-CFMnSdFru2XDhXnDfID6s1mwuGiCNpsnAHfXW25Ce4zllZujC1S2pu6fnS0iutCOFH0yFyc0rfnziCsYXPSEBdQtEamBY-lAqLxG2UGqqXGFGPcQsvKmRQ9Rr7I3Pg',
            'fBU6SQaCRpO-cXAhHdY3OG:APA91bFd8IbQMVk8UFzuNfiZGk_dGUp-_jE_1DI_z8HReb8Cs4HUFVjlfzpMHYEIZaqjxjztmTPqnjga4kY5_iGSZBME23L0puqa4151KdzH5WKz-LhzklXGmoULRBwo0ayYAJVH8dmm',
            'dkESHEiRSACsXgnNIsSd9F:APA91bE7fEHss-CFMnSdFru2XDhXnDfID6s1mwuGiCNpsnAHfXW25Ce4zllZujC1S2pu6fnS0iutCOFH0yFyc0rfnziCsYXPSEBdQtEamBY-lAqLxG2UGqqXGFGPcQsvKmRQ9Rr7I3Pg',
            'dkESHEiRSACsXgnNIsSd9F:APA91bE7fEHss-CFMnSdFru2XDhXnDfID6s1mwuGiCNpsnAHfXW25Ce4zllZujC1S2pu6fnS0iutCOFH0yFyc0rfnziCsYXPSEBdQtEamBY-lAqLxG2UGqqXGFGPcQsvKmRQ9Rr7I3Pg',
            'dkESHEiRSACsXgnNIsSd9F:APA91bE7fEHss-CFMnSdFru2XDhXnDfID6s1mwuGiCNpsnAHfXW25Ce4zllZujC1S2pu6fnS0iutCOFH0yFyc0rfnziCsYXPSEBdQtEamBY-lAqLxG2UGqqXGFGPcQsvKmRQ9Rr7I3Pg',
            'fBU6SQaCRpO-cXAhHdY3OG:APA91bFd8IbQMVk8UFzuNfiZGk_dGUp-_jE_1DI_z8HReb8Cs4HUFVjlfzpMHYEIZaqjxjztmTPqnjga4kY5_iGSZBME23L0puqa4151KdzH5WKz-LhzklXGmoULRBwo0ayYAJVH8dmm',
            'fBU6SQaCRpO-cXAhHdY3OG:APA91bFd8IbQMVk8UFzuNfiZGk_dGUp-_jE_1DI_z8HReb8Cs4HUFVjlfzpMHYEIZaqjxjztmTPqnjga4kY5_iGSZBME23L0puqa4151KdzH5WKz-LhzklXGmoULRBwo0ayYAJVH8dmm',
            'fIc4A63rRlGv0yI32DCOfs:APA91bE0lWotxp7N6iJ8oK2IhdVxsGKCezlQs90bQ43wsqbkJAbTNP8aKMLJIILuDULkcUeyTY0Tr3Vg62OevHl5QhJocDAcARWH2HO_OfjecM4Wgm4oCjow4iCwGP6cggUVx1haqtui'];;
            $this->api->send_notification($token, false, 'Test Notif!', 'Isi test notif manual');
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
