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

    public function __construct(IUserRepository $UserRepository) {
        $this->UserRepository = $UserRepository;
    }

    public function index(){
        $Khachhangs = $this->UserRepository->allKhachhang();

        return view('admin.khachhangs.index', ['Khachhangs' => $Khachhangs]);
    }
}