<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Models\PasswordReset;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Hiển thị form quên mật khẩu
    public function showForgotForm()
    {
        return view('frontend.auth.forgot-password');
    }

    // Xử lý gửi email với mã code
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = NguoiDung::where('email', $request->email)
                         ->where('vai_tro', 'customer')
                         ->where('trang_thai', 'active')
                         ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
        }

        // Xóa mã cũ nếu có
        PasswordReset::where('email', $request->email)
                    ->where('user_type', 'customer')
                    ->delete();

        // Tạo mã 6 số ngẫu nhiên
        $code = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        PasswordReset::create([
            'email' => $request->email,
            'code' => $code,
            'user_type' => 'customer',
            'created_at' => now()
        ]);

        // Gửi email
        try {
            Mail::to($request->email)->send(new ResetPasswordMail($code, $request->email, 'customer'));
            
            // Chuyển đến trang nhập mã
            return redirect()->route('customer.password.verify', ['email' => $request->email])
                           ->with('success', 'Đã gửi mã xác nhận đến email của bạn. Vui lòng kiểm tra hộp thư.');
        } catch (\Exception $e) {
            \Log::error('Không thể gửi email reset password: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.']);
        }
    }

    // Hiển thị form nhập mã và mật khẩu mới
    public function showVerifyForm(Request $request)
    {
        $email = $request->email;
        
        if (!$email) {
            return redirect()->route('customer.password.request')
                           ->withErrors(['email' => 'Email không hợp lệ.']);
        }

        return view('frontend.auth.verify-reset-code', compact('email'));
    }

    // Xử lý xác nhận mã và đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $passwordReset = PasswordReset::where('email', $request->email)
                                    ->where('code', $request->code)
                                    ->where('user_type', 'customer')
                                    ->first();

        if (!$passwordReset) {
            return back()->withErrors(['code' => 'Mã xác nhận không đúng.']);
        }

        // Kiểm tra mã có hết hạn không (15 phút)
        if ($passwordReset->isExpired()) {
            PasswordReset::where('email', $request->email)
                        ->where('user_type', 'customer')
                        ->delete();
            return back()->withErrors(['code' => 'Mã xác nhận đã hết hạn. Vui lòng yêu cầu mã mới.']);
        }

        // Cập nhật mật khẩu
        $user = NguoiDung::where('email', $request->email)
                         ->where('vai_tro', 'customer')
                         ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản.']);
        }

        $user->update([
            'mat_khau' => Hash::make($request->password)
        ]);

        // Xóa mã đã sử dụng
        PasswordReset::where('email', $request->email)
                    ->where('code', $request->code)
                    ->where('user_type', 'customer')
                    ->delete();

        return redirect()->route('customer.login')
                        ->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập với mật khẩu mới.');
    }
}