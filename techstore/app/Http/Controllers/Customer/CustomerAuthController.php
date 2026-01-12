<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tìm user theo email
        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
        }

        // Kiểm tra password
        if (!Hash::check($request->password, $user->mat_khau)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
        }

        // Kiểm tra tài khoản có bị khóa không
        if (!$user->isActive()) {
            return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.'])->withInput();
        }

        // Chỉ cho phép customer đăng nhập
        if (!$user->isCustomer()) {
            return back()->withErrors(['email' => 'Tài khoản admin không thể đăng nhập tại đây.'])->withInput();
        }

        // Đăng nhập với guard customer
        Auth::guard('customer')->login($user, $request->has('remember'));
        $request->session()->regenerate();
        
        return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:nguoi_dung,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = NguoiDung::create([
            'ten' => $request->name,
            'email' => $request->email,
            'mat_khau' => Hash::make($request->password),
            'vai_tro' => 'customer', // Mặc định là customer
            'trang_thai' => 'active',
        ]);

        Auth::guard('customer')->login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
}
