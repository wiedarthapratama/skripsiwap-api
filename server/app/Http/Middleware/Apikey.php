<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Apikey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apikey = $request->header('apikey');
        if($apikey != "Luwak White Koffie Kopi Nikmat Tidak Bikin Kembung"){
            return response()->json(['status'=>false,'message'=>'Forbidden for access this API'], 403);
        }else{
            return $next($request);
        }
    }
}
