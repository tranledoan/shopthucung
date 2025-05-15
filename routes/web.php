<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    CartController
};

Route::get('/', function () {
  return view('layout');
})->name('home');


Route::get('/login-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'showLoginForm'])->name('login.khachhang');
Route::post('/login-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'login']);
Route::post('/logout-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'logout'])->name('logout.khachhang');

// router login , register ,logout
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');


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

