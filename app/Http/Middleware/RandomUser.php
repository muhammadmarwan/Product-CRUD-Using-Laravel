<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Models\User;

class RandomUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            return $next($request);
        }else{
            $userData = array(
                'email' => 'mhdmarwan111@gmail.com',
                'password' => '56995699'
            );

            if(Auth::attempt($userData))
            {
                return $next($request);
            }else{
                // return back()->with('error', 'Wrong Login Details');
                return $next($request);
            }
        }
    }
}
