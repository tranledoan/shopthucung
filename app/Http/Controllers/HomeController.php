<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sanpham;

use App\Repositories\ISanphamRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
   public function viewAll(Request $request)
{
    $page = $request->page ?? 1;

    // Kiểm tra page có phải số nguyên dương hay không
    if (!ctype_digit(strval($page)) || (int)$page < 1) {
        return redirect()->route('viewAll', ['page' => 1])
            ->with('error', 'Số trang không hợp lệ. Đã chuyển về trang đầu.');
    }

    // Lấy dữ liệu phân trang
    $products = SanPham::paginate(10, ['*'], 'page', $page);

    // Nếu page vượt quá max page thì redirect về trang cuối cùng kèm thông báo lỗi
    if ($page > $products->lastPage()) {
        return redirect()->route('viewAll', ['page' => $products->lastPage()])
            ->with('error', 'Trang bạn yêu cầu vượt quá số trang tối đa. Đã chuyển về trang cuối.');
    }

    // Trả view với dữ liệu products
    return view('pages.viewall', ['sanphams' => $products]);
}


    public function services()
    {
        return view('pages.services');
    }

    public function search(Request $request)
    {
        $searchs = $this->sanphamRepository->searchProduct($request);
        return view('pages.search')->with('searchs', $searchs)->with('tukhoa', $request->input('tukhoa'));
    }

    public function detail($id)
    {
        if (!is_numeric($id)) {
            // Nếu ID không hợp lệ, trả về thông báo lỗi
             return redirect()->route('detail', ['id' => 1])->with('error', 'Không tìm thấy trang.');
        }

        try {
            // Tìm sản phẩm theo ID, nếu không tìm thấy sẽ ném ra ModelNotFoundException
            $sanPham = SanPham::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Nếu không tìm thấy sản phẩm, trả về thông báo lỗi
            return redirect()->route('detail', ['id' => 1])->with('error', 'Không tìm thấy trang.');
        }
        $randoms = $this->sanphamRepository->randomProduct()->take(5);
        return view('pages.detail', ['sanpham' => $sanPham, 'randoms' => $randoms]);
    }
}
