<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm user theo email
        $user = \App\Models\NguoiDung::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }

        // Kiểm tra password
        if (!\Hash::check($request->password, $user->mat_khau)) {
            throw ValidationException::withMessages([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }

        // Kiểm tra tài khoản có bị khóa không
        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'email' => 'Tài khoản của bạn đã bị khóa.',
            ]);
        }

        // Kiểm tra quyền admin
        if (!$user->isAdmin()) {
            throw ValidationException::withMessages([
                'email' => 'Bạn không có quyền truy cập vào khu vực quản trị.',
            ]);
        }

        // Đăng nhập với guard admin
        Auth::guard('admin')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

