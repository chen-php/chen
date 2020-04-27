<?php

namespace App\Http\Middleware;

use Closure;

class IsLogin
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
        if(session()->get('user')||session()->get('admin')||session()->get('student')||session()->get('teacher')){
			return $next($request);
		}else{
			return redirect('/login')->with('errors','请注意下素质！！！');
		}
    }
}
