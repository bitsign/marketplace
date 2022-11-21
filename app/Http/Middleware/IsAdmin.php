<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('AdminUser') && ($request->path() !='admin.login' )){
            return redirect('admin/login')->with('danger',__('login_needed'));
        }

        if(session()->has('AdminUser') && ($request->path() == 'admin.login') ){
            return back();
        }
        return $next($request);
    }
}
