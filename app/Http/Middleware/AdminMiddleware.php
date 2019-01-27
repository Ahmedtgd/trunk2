<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AdminMiddleware
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
        if (!Auth::check()) {
            return redirect("/");
        }
        if($user = Auth::user()){
            $roles = $user->getRoles()->pluck('slug')->toArray();

            if(in_array('adm',$roles))
                return $next($request)
            ->header("Cache-Control","private, must-revalidate,
        max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0")
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

            return redirect("/")  ;
        }

        return redirect("/");
    }
}
