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

    public function __construct(ISanphamRepository $sanphamRepository)
    {
        $this->sanphamRepository = $sanphamRepository;
    }

    public function index()
    {
        $alls = $this->sanphamRepository->allProduct();
        $sanphams = $this->sanphamRepository->relatedProduct();
        $dogproducts = $this->sanphamRepository->dogProduct();
        $catproducts = $this->sanphamRepository->catProduct();
        $choGiongs = $this->sanphamRepository->choGiong();
        $meoGiongs = $this->sanphamRepository->meoGiong();
        return view('pages.home', [
            'alls' => $alls,
            'sanphams' => $sanphams,
            'dogproducts' => $dogproducts,
            'catproducts' => $catproducts,
            'choGiongs' => $choGiongs,
            'meoGiongs' => $meoGiongs,
        ]);
    }

    //-- hieu 
    public function showFeaturedProducts()
    {
        $sanphams = Sanpham::all();
        return view('yourview', compact('sanphams'));
    }

    public function congiong()
    {
        $choGiongs = $this->sanphamRepository->choGiong();
        $meoGiongs = $this->sanphamRepository->meoGiong();

        return view('pages.congiong', [
            'choGiongs' => $choGiongs,
            'meoGiongs' => $meoGiongs,
        ]);
    }

    // xem them
    public function viewAll()
    {
        $viewAllPaginations = $this->sanphamRepository->viewAllWithPagi();
        return view('pages.viewall', ['sanphams' => $viewAllPaginations]);
    }
    public function services()
    {
        return view('pages.services');
    }
     public function detail($id){
        // Lấy thông tin của sản phẩm dựa trên $id
        $sanpham = Sanpham::findOrFail($id);
        $randoms = $this->sanphamRepository->randomProduct()->take(5);
        return view('pages.detail', ['sanpham' => $sanpham, 'randoms' => $randoms]);
    }

}
