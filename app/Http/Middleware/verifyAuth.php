<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class verifyAuth
{

    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()){
            return redirect()->route('auth.index')->with('message','Favor fazer login');
        }
        return $next($request);
    }
}
