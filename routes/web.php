<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sanpham/detail/{id}', [HomeController::class, 'detail'])->name('detail');

Route::get('/congiong', [HomeController::class, 'congiong'])->name('congiong');
Route::get('/viewAll', [HomeController::class, 'viewAll'])->name('viewAll');
Route::get('/services', [HomeController::class, 'services'])->name('services');