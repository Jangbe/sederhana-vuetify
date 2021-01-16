<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function(){
    Route::get('index/{category?}', [ProductController::class,'index']);
    Route::get('index/{id:id_product}/show', [ProductController::class,'show']);
    Route::get('search/{category}/{id}', [ProductController::class,'search']);
});

Route::prefix('kategori')->group(function(){
    Route::get('index', [CategoryController::class, 'index']);
    Route::get('show/{id}', [CategoryController::class, 'show']);
    Route::post('edit', [CategoryController::class, 'edit']);
    Route::post('delete', [CategoryController::class, 'destroy']);
});

Route::prefix('keranjang')->group(function(){
    Route::post('make', [CartController::class, 'make']);
    Route::get('get', [CartController::class, 'getCart']);
    Route::get('hapus/{id}', [CartController::class, 'deleteCart']);
    Route::patch('store', [CartController::class, 'store']);
});

Route::prefix('admin')->middleware('role:1')->group(function(){
    Route::get('getCarts/{id_buyer?}', [AdminController::class, 'getCarts']);
    Route::get('struct/{search?}', [AdminController::class, 'struct']);
    Route::post('make', [AdminController::class, 'make']);
    Route::post('category', [AdminController::class, 'category']);
    Route::post('product', [ProductController::class, 'store']);
    Route::post('edit-product', [ProductController::class, 'edit']);
    Route::post('add-stok', [ProductController::class, 'add_stok']);
    Route::post('delete', [ProductController::class, 'destroy']);
});

Route::prefix('auth')->group(function(){
    Route::get('init', [AuthController::class, 'init']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
