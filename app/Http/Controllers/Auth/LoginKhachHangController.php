<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginKhachHangController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.khachhang-login'); // nếu bạn có view riêng cho khách hàng
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('khachhang')->attempt($credentials)) {
            return redirect()->intended('/'); // hoặc trang bạn muốn chuyển đến sau đăng nhập
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    public function logout(Request $request)
    {
        Auth::guard('khachhang')->logout();
        return redirect('/');
    }
}
