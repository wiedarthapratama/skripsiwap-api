<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new ApiController();
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $input['id_user'] = $this->api->getUserLogin();
    
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'nohp' => 'required'
            ]);
    
            if($validator->fails()) {
                $res['status'] = false;
                $res['message'] = $validator->errors()->first();
                return response()->json($res, 400);
            }
    
            User::find($input['id_user'])->update($input);
    
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Profil berhasil diupdate";
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Profil gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code); 
    }

    public function password(Request $request)
    {
        try {
            $input = $request->all();
            $input['id_user'] = $this->api->getUserLogin();
    
            $validator = Validator::make($request->all(), [
                'password_lama' => 'required',
                'password_baru' => 'required',
                'password_konfirmasi' => 'required'
            ]);
    
            if($validator->fails()) {
                $res['status'] = false;
                $res['message'] = $validator->errors()->first();
                return response()->json($res, 400);
            }

            if($input['password_baru']!=$input['password_konfirmasi']){
                $code = 400;
                $res['status'] = false;
                $res['message'] = "password baru dan konfirmasi password tidak sesuai";
            }else{
                $user = User::find($input['id_user']);
                if (Hash::check($input['password_lama'], $user->password)) {
                    $user->update([
                        'password'=>Hash::make($input['password_baru'])
                    ]);
            
                    $code = 200;
                    $res['status'] = true;
                    $res['message'] = "Profil berhasil diupdate";
                }else{
                    $code = 400;
                    $res['status'] = false;
                    $res['message'] = "password tidak sesuai";
                }
            }
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Profil gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code); 
    }
}
