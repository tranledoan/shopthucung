<?php

// use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\{
  OrderViewController,
  HomeController,
  CartController
};
use App\Http\Controllers\admin\{AdminController, ProductController, DanhmucController, OrderController, UserController};



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
Route::post('/dathang', [CartController::class, 'dathang'])->name('dathang');
Route::post('/vnpay', [CartController::class, 'vnpay'])->name('vnpay');
Route::get('/thongbaodathang', [CartController::class, 'thongbaodathang'])->name('thongbaodathang');

//order
Route::get('/donhang', [OrderViewController::class, 'donhang']);
Route::get('/donhang/edit/{id}', [OrderViewController::class, 'edit'])->name('donhang.edit');



//admin
//login

Route::prefix('/')->group(function () {


  Route::get('/admin/products', [ProductController::class, 'index'])->name('product.index');
  Route::get('/admin/products/search', [AdminController::class, 'search'])->name('adminSearch');
  Route::get('/admin/products/create', [ProductController::class, 'create'])->name('product.create');
  Route::post('/admin/products', [ProductController::class, 'store'])->name('product.store');
  Route::get('/admin/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
  Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('product.update');
  Route::delete('/admin/products/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

  //catagory
  Route::get('/admin/danhmucs', [DanhmucController::class, 'index'])->name('danhmuc.index');
  Route::get('/admin/danhmucs/create', [DanhmucController::class, 'create'])->name('danhmuc.create');
  Route::post('/admin/danhmucs', [DanhmucController::class, 'store'])->name('danhmuc.store');
  Route::get('/admin/danhmucs/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
  Route::put('/admin/danhmucs/update/{danhmuc}', [DanhmucController::class, 'update'])->name('danhmuc.update');
  Route::delete('/admin/danhmucs/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');
});
Route::prefix('admin')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::get('/admin/products', [ProductController::class, 'index'])->name('product.index');
  //product
});



Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


//Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin_logout', [AdminController::class, 'admin_logout']);
Route::get('/dashboard', [AdminController::class, 'dashboard']);
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
Route::delete('/admin/khachhang/{id}', [UserController::class, 'destroy'])->name('adminDeleteUser');


//admin
Route::prefix('/')->group(function () {
  Route::get('/admin', [AdminController::class, 'index']);
  Route::post('/signinDashboard', [AdminController::class, 'signin_dashboard']);
});

Route::get('/admin/product/search', [AdminController::class, 'search'])->name('adminSearch');
Route::get('/admin/product/create', [ProductController::class, 'create'])->name('product.create');
Route::delete('/admin/product/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/admin/orders/edit/{orders}', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/admin/orders/update/{orders}', [OrderController::class, 'update'])->name('orders.update');




Route::get('/admin/user/search', [UserController::class, 'search'])->name('adminSearchUser');


Route::get('frontend/upload/{filename}', function ($filename) {
    $path = public_path('frontend/upload/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});
// Hiển thị form edit
Route::get('/admin/khachhangs/{id}/edit', [UserController::class, 'editUser'])->name('adminEditUser');

// Xử lý cập nhật
Route::put('/admin/khachhangs/{id}', [UserController::class, 'updateUser'])->name('adminUpdateUser');
