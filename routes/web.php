<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return view('welcome');
})->name('home');


//route admin
Route::prefix('/')->middleware('admin.login')->group(function(){

  Route::get('/admin/danhmuc', [DanhmucController::class, 'index'])->name('danhmuc.index');
  Route::get('/admin/danhmuc/create', [DanhmucController:: class, 'create'])->name('danhmuc.create');
  Route::post('/admin/danhmuc', [DanhmucController::class, 'store'])->name('danhmuc.store');
  Route::get('/admin/danhmuc/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
  Route::put('/admin/danhmuc/update/{danhmuc}', [DanhmucController::class, 'update'])->name('danhmuc.update');
  Route::delete('/admin/danhmuc/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');
});