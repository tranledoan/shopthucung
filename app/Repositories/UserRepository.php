<?php
namespace App\Repositories;

use App\Repositories\IUserRepository;
use App\Models\Khachhang;

class UserRepository implements IUserRepository{
    public function allKhachhang(){
        return Khachhang::all();
    }
 
}