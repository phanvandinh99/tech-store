<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu chưa đăng nhập, redirect về trang login admin
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Nếu đã đăng nhập nhưng không phải admin
        if (!auth()->user()->isAdmin()) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Bạn không có quyền truy cập trang quản trị!');
        }

        return $next($request);
    }
}
