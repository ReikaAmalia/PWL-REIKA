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

use App\Http\Controllers\KategoriCotroller;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriCotroller::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// //jb 4 
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

//jb 5 terbaru prak 1
Route::get('/', [WelcomeController::class, 'index']);

//jb 5 terbaru prak 2
Route::group(['prefix' => 'user'], function () {
Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});