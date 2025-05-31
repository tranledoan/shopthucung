<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }
    public function register( )
    {
        return view('pages.register');
    }
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:khachhang,email|max:100',
            'password' => 'required|min:6|max:64',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^[0-9]{10,11}$/'
        ], [
            'required' => ':attribute không được để trống.',
            'email' => 'Email không đúng định dạng.',
            'unique' => 'Email đã tồn tại.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'regex' => ':attribute không đúng định dạng (chỉ gồm 10–11 chữ số).'
        ], [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
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
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:64'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.max' => 'Email tối đa 100 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu tối đa 64 ký tự'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();

            if ($user->id_phanquyen == 1) {
                return redirect('/')->with('thongbao', 'Đăng nhập admin thành công');
            } elseif ($user->id_phanquyen == 2) {
                return redirect('/')->with('thongbao', 'Đăng nhập thành công');
            } else {
                Auth::guard('web')->logout();
                return back()->with('error', 'Tài khoản không có quyền truy cập.');
            }
        }
        return back()->with('error', 'Sai tên tài khoản hoặc mật khẩu');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
