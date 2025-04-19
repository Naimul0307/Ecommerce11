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

    //route for brands
    Route::get('/admin/brands',[AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',[AdminController::class, 'add_brand'])->name('admin.add.brand');
    Route::post('/admin/brand/store',[AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}',[AdminController::class, 'edit_brand'])->name('admin.edit.brand');
    Route::put('/admin/brand/update',[AdminController::class, 'update_brand_store'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete',[AdminController::class, 'delete_brand'])->name('admin.brand.delete');

    //route for catefories
    Route::get('/admin/categories',[AdminController::class, 'category'])->name('admin.category');
    Route::get('/admin/category/add',[AdminController::class, 'add_category'])->name('admin.add.category');
    Route::post('/admin/category/store',[AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}',[AdminController::class,'edit_category'])->name('admin.edit.category');
    Route::put('/admin/category/update',[AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete',[AdminController::class, 'delete_category'])->name('admin.category.delete');

    //route for products
    Route::get('/admin/products',[AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add',[AdminController::class, 'add_product'])->name('admin.add.product');
    Route::post('/admin/product/store',[AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}',[AdminController::class,'edit_product'])->name('admin.edit.product');
    Route::put('/admin/product/update',[AdminController::class, 'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete',[AdminController::class,'delete_product'])->name('admin.product.delete');
});
