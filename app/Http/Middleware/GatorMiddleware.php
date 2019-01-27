<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class GatorMiddleware
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
        if (Auth::check() && Auth::user()->hasAccess('gator')) {
            return $next($request);
        }else{
            $message=" Unauthorized Access to Gator!
            Contact administrator if access is required.";
            $message_type="error";
            return view('common.generic',compact('message','message_type'));
        }
        
    }
}
