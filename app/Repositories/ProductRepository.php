<?php
namespace App\Repositories;

use App\Repositories\IProductRepository;
use App\Models\Sanpham;

class ProductRepository implements IProductRepository{
    public function allProduct(){
        return Sanpham::paginate(10);
    }
    
}