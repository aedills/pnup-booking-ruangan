<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('uuid')) {
            return $next($request);
        } else {
            return redirect()->route('auth.login')->with('error', 'Anda tidak memiliki akses, silahkan login terlebih dahulu!');
        }
    }
}
