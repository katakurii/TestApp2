<?php

namespace App\Http\Middleware;

use Closure;
use User;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->level == 1){
            
            return $next($request);
        }
        return redirect('/home');
    }
}
