<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Khachhang;
use App\Models\Phanquyen;

use App\Repositories\IUserRepository;

class UserController extends Controller
{

    private $UserRepository;

    public function __construct(IUserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function index(Request $request)
{
    $keyword = $request->input('tukhoa');

    // Lấy dữ liệu Khachhang phân trang (ví dụ 10 bản ghi / trang), truyền keyword nếu có để lọc
    $Khachhangs = $this->UserRepository->allKhachhang();

    $currentPage = $Khachhangs->currentPage();
    $lastPage = $Khachhangs->lastPage();

    $pageParam = $request->query('page');

    // Kiểm tra page truyền vào có hợp lệ không
    if (!is_null($pageParam) && (!ctype_digit($pageParam) || (int)$pageParam > $lastPage)) {
        return redirect()->route('khachhang.index', ['page' => $lastPage, 'tukhoa' => $keyword])
                         ->with('error', 'Trang không hợp lệ, đã chuyển về trang hợp lệ gần nhất.');
    }

    return view('admin.khachhangs.index', [
        'Khachhangs' => $Khachhangs,
        'keyword' => $keyword
    ]);
}

    public function search(Request $request)
    {
        $tukhoa = $request->tukhoa;
        $searchs = Khachhang::where('hoten', 'like', "%$tukhoa%")
            ->orWhere('email', 'like', "%$tukhoa%")
            ->orWhere('sdt', 'like', "%$tukhoa%")
            ->paginate(10);

        return view('admin.khachhangs.search', compact('searchs', 'tukhoa'));
    }
}