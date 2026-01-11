<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfUserIsActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->Status !== 'مفعل') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'حسابك غير مفعل، يرجى التواصل مع الإدارة.']);
        }

        return $next($request);
    }
}
