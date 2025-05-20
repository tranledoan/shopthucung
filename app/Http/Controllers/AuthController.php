<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        return view('pages.login');
    }
    public function register(){
        return view('pages.register');
    }
    public function registerPost(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:khachhang,email',
        'password' => 'required|min:6',
        'address' => 'required',
        'phone' => 'required',
    ], [
        'required' => ':attribute không được để trống.',
        'email' => 'Email không đúng định dạng.',
        'unique' => 'Email đã tồn tại.',
        'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
    ], [
        'name' => 'Họ và tên',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'address' => 'Địa chỉ',
        'phone' => 'Điện thoại',
    ]);

    $kh = new Khachhang();
    $kh->hoten = $request->name;
    $kh->email = $request->email;
    $kh->password = Hash::make($request->password);
    $kh->diachi = $request->address;
    $kh->sdt = $request->phone;
    $kh->id_phanquyen = 2;
    $kh->save();

    return back()->with('thongbao', 'Đăng ký tài khoản thành công');
}

    public function loginPost(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ], [
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không hợp lệ',
        'password.required' => 'Vui lòng nhập mật khẩu'
    ]);
    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    // Xử lý đăng nhập
    if (Auth::attempt($credentials)) {
        return redirect('/')->with('thongbao', 'Đăng nhập thành công');
    }

    return back()->with('error', 'Sai tên tài khoản hoặc mật khẩu');
}

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
