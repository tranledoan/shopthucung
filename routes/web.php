<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{


    HomeController,
    CartController
};
use App\Http\Controllers\admin\{AdminController,ProductController,DanhmucController,OrderController,UserController};
Route::get('/', function () {
  return view('layout');
})->name('home');


// Route::get('/login-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'showLoginForm'])->name('login.khachhang');
// Route::post('/login-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'login']);
// Route::post('/logout-khachhang', [\App\Http\Controllers\Auth\LoginKhachHangController::class, 'logout'])->name('logout.khachhang');

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
//cart
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::get('add-go-to-cart/{id}', [CartController::class, 'addGoToCart'])->name('add_go_to_cart');
Route::patch('update-cart', [CartController::class, 'update'])->name('update_cart');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/dathang', [CartController:: class, 'dathang'])->name('dathang');
Route::post('/vnpay', [CartController:: class, 'vnpay'])->name('vnpay');
Route::get('/thongbaodathang', [CartController:: class, 'thongbaodathang'])->name('thongbaodathang');

//order
Route::get('/donhang', [OrderViewController:: class, 'donhang']);

Route::prefix('/')->middleware('orderview')->group(function(){
    Route::get('/donhang/edit/{id}', [OrderViewController::class, 'edit'])->name('donhang.edit');
});

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

  //Route::get('/dashboard', [AdminController::class, 'dashboard']);
  Route::get('/admin_logout', [AdminController::class, 'admin_logout']);

  Route::get('/admin/product', [ProductController::class, 'index'])->name('product.index');
 

  Route::post('/admin/product', [ProductController::class, 'store'])->name('product.store');
  Route::get('/admin/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
  

  Route::get('/admin/danhmuc', [DanhmucController::class, 'index'])->name('danhmuc.index');
  Route::get('/admin/danhmuc/create', [DanhmucController::class, 'create'])->name('danhmuc.create');
  
  Route::get('/admin/danhmuc/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
 
  Route::delete('/admin/danhmuc/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');

  Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
  
  Route::get('/admin/khachhang', [UserController::class, 'index'])->name('khachhang.index');
  
  
