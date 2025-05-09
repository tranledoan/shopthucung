<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sanpham;

use App\Repositories\ISanphamRepository;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    private $sanphamRepository;
    public function index()
{
    // Dữ liệu giả
    $danhsachsp = [
        (object)[
            'tensp' => 'Chó Poodle',
            'gia' => 3000000,
            'hinhanh' => 'frontend/img/poodle.jpg',
        ],
        (object)[
            'tensp' => 'Mèo Anh lông ngắn',
            'gia' => 2500000,
            'hinhanh' => 'frontend/img/meo-anh.jpg',
        ],
        // Thêm bao nhiêu sản phẩm tùy thích
    ];

    return view('pages.home', compact('danhsachsp'));
}


   

   
}
