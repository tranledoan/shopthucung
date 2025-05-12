<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\{
    HomeController,
    CartController
};

Route::get('/', function () {
  return view('welcome');
})->name('home');


Route::get('page.congiong', function () {
  return view('congiong');
})->name('congiong');


Route::get('/congiong', function () {
  return view('congiong');
})->name('congiong');

Route::get('/', [HomeController::class, 'index']);

Route::get('/sanpham/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/congiong', [HomeController::class, 'congiong']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/viewAll', [HomeController::class, 'viewAll'])->name('viewAll');
Route::get('/services', [HomeController::class, 'services'])->name('services');
// router cart
// Các route giỏ hàng & thanh toán cần đăng nhập

