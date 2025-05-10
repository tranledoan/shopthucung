<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanpham;

class ProductController extends Controller
{
    public function show($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        return view('pages.detail', compact('sanpham'));
    }
}
