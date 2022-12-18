<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use Validator;
use Auth;

class ProfileController extends Controller
{
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
                return response()->json($validator->errors(), 400);
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
                return response()->json($validator->errors(), 400);
            }

            if(auth()->attempt($validator->validated())){
                
            }
    
            User::find($input['id_user'])->update($input);
    
            $code = 200;
            $res['status'] = true;
            $res['message'] = "Profil berhasil diupdate";
            $res['data'] = $data;
        } catch (\Exception $e) {
            $code = 500;
            $res['status'] = false;
            $res['message'] = "Profil gagal diupdate";
            $res['error'] = $e->getMessage();
        }
        return response()->json($res, $code); 
    }
}
