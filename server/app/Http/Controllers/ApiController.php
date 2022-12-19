<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;

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
}
