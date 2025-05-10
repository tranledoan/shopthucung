<?php
namespace App\Repositories;

use App\Repositories\IDanhmucRepository;
use App\Models\Danhmuc;

class DanhmucRepository implements IDanhmucRepository{

    public function allDanhmuc(){
        return Danhmuc::all();
    }
}