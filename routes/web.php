<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    AdminController,
    DanhmucController,
    ProductController,
    HomeController,
    CartController
};

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

//admin
Route::prefix('/')->middleware('admin.login')->group(function(){
    //login
    Route::get('/dashboard', [AdminController:: class, 'dashboard']);
    Route::get('/admin_logout', [AdminController:: class, 'admin_logout']); 
    
    //product
    Route::get('/admin/products', [ProductController:: class, 'index'])->name('product.index');
    Route::get('/admin/products/search', [AdminController:: class, 'search'])->name('adminSearch');
    Route::get('/admin/products/create', [ProductController:: class, 'create'])->name('product.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/products/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
    
    //catagory
    Route::get('/admin/danhmuc', [DanhmucController::class, 'index'])->name('danhmuc.index');
    Route::get('/admin/danhmuc/create', [DanhmucController:: class, 'create'])->name('danhmuc.create');
    Route::post('/admin/danhmuc', [DanhmucController::class, 'store'])->name('danhmuc.store');
    Route::get('/admin/danhmuc/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
    Route::put('/admin/danhmuc/update/{danhmuc}', [DanhmucController::class, 'update'])->name('danhmuc.update');
    Route::delete('/admin/danhmuc/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');
});
