<?php
//
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/accound-dashboard',[UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin-dashboard',[AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands',[AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',[AdminController::class, 'add_brand'])->name('admin.add_brand');
    Route::post('/admin/brand/store',[AdminController::class, 'brand_store'])->name('admin.brand_store');
});
