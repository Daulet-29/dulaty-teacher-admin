<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTeacherRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Проверка роли пользователя
        if (Auth::check() && Auth::user()->role == 'teacher') {
            // Проверка маршрута
            $allowedRoutes = [
                'admin',
                'admin/student-lessons',
            ];

            // Если текущий маршрут не в списке разрешенных, перенаправляем
            if (!$request->is($allowedRoutes) && !$request->is('admin/student-lessons/*')) {
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}

