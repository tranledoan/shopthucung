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


    public function getOrderView()
    {
        return Dathang::orderby('id_dathang', 'desc')->take(6)->get();
    }
    public function totalsCustomer()
    {
        return Khachhang::count();
    }

    public function totalsOrders()
    {
        return Dathang::count();
    }
    public function totalsMoney()
    {
        return DB::table('chitiet_donhang')
            ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
            ->where('dathang.trangthai', 'giao thành công')
            ->sum(DB::raw('chitiet_donhang.giakhuyenmai * chitiet_donhang.soluong'));
    }
    
    public function totalsSaleProducts()
    {
        return DB::table('chitiet_donhang')
        ->join('dathang', 'chitiet_donhang.id_dathang', '=', 'dathang.id_dathang')
        ->where('dathang.trangthai', 'giao thành công')
        ->sum('chitiet_donhang.soluong');
    }


}