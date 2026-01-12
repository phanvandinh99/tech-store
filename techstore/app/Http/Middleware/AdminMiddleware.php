<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đăng nhập với guard admin
        if (!auth('admin')->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để tiếp tục!',
                    'redirect' => route('admin.login')
                ], 401);
            }
            return redirect()->route('admin.login');
        }

        // Nếu đã đăng nhập nhưng không phải admin
        if (!auth('admin')->user()->isAdmin()) {
            auth('admin')->logout();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền truy cập trang quản trị!',
                    'redirect' => route('admin.login')
                ], 403);
            }
            return redirect()->route('admin.login')
                ->with('error', 'Bạn không có quyền truy cập trang quản trị!');
        }

        return $next($request);
    }
}
