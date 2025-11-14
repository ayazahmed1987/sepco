<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guard = $guards[0];
        if (!Auth::guard($guard)->check()) {
            if($guard=='admin'){
                $guard='manager';
            }
            return redirect()->route("{$guard}.login");
        }
        return $next($request);
    }
}
