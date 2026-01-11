<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        // التحقق من تسجيل الدخول والصلاحية
        if (Auth::check() && Auth::user()->can($permission)) {
            return $next($request);
        }

        // عرض خطأ 403 في حالة عدم امتلاك الصلاحية
        abort(403, 'Unauthorized access.');
    }
}
