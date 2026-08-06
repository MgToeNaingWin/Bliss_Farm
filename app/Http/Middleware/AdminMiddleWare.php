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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            return back();
        }

        if ($request->route()->getName() === 'login' || $request->route()->getName() === 'register') {
            return back();
        }

        return $next($request);
    }
}

