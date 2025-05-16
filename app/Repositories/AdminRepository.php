<?php
namespace App\Repositories;

use App\Repositories\IAdminRepository;
use App\Http\Requests;

use App\Models\Khachhang;
use App\Models\Sanpham;
use App\Models\Dathang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminRepository implements IAdminRepository{

    public function signIn($data){
        $credetials = [
            'email' => $data->email,
            'password' => $data->password
        ];

        if(Auth::attempt($credetials)){
            return redirect('/dashboard');
        }

        return back()->with('thongbao', 'Sai tên tài khoản hoặc mật khẩu');

    }
    public function logOut(){
        Auth::logout();
        return redirect('/admin');
    }

   

}
