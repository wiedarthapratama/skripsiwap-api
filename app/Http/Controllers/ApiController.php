<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    function getUserLogin() 
    {
        return auth()->user()->id;
    }
}
