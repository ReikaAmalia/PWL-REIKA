<?php

// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\productController;
// use App\Http\Controllers\SalesController;
// use App\Http\Controllers\UserController;
// use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [HomeController::class, 'index']);

// Route::prefix('category')->group(function () {
//     Route::get('food-beverage', [productController::class, 'foodBeverage']);
//     Route::get('beauty-health', [ProductController::class, 'beautyHealth']);
//     Route::get('home-care', [ProductController::class, 'homeCare']);
//     Route::get('baby-kid', [ProductController::class, 'babyKid']);
// });

// Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);

// Route::get('/sales', [SalesController::class, 'index']);

// TERBARU

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
//jb 4 
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store']);

//modifikasi 
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create'); // Form pembuatan kategori baru
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store'); // Menyimpan kategori baru

Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::post('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
Route::resource('kategori', KategoriController::class);

Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');
