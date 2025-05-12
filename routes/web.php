<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;



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