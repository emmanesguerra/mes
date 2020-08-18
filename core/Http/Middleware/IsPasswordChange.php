<?php

namespace Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsPasswordChange
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
        if(empty(Auth::user()->password_chaged_at)) {
            return redirect()->route('admin.changepswd');
        }
        
        return $next($request);
    }
}
