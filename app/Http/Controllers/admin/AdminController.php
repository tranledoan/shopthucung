<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Repositories\IAdminRepository;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    private $AdminRepository;

    public function __construct(IAdminRepository $AdminRepository) {
        $this->AdminRepository = $AdminRepository;
    }

    public function index(){
        return view('admin_login');
    }
    public function signin_dashboard(Request $request){
        return $this->AdminRepository->signIn($request);
    }
    public function admin_logout(){
        return $this->AdminRepository->logOut();
    }
}
