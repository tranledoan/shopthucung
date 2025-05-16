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
        // $Khachhangs = $this->UserRepository->allKhachhang();

        // return view('admin.khachhangs.index', ['Khachhangs' => $Khachhangs]);
        $keyword = $request->input('tukhoa');

        $Khachhangs = $this->UserRepository->allKhachhang($keyword);

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