<?php

namespace App\Http\Controllers;


use App\Models\Sanpham;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }
 
}