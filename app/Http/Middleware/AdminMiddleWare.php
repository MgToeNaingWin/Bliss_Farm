<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class AdminMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if( auth()->user()){

            if( auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin'){
                if( $request->route()->getName() == 'login' || $request->route()->getName() == 'register'){
                    return back();
                }
                return $next($request);
            }
        return back();
     }else{
        return $next($request);
     }

    }

    }

