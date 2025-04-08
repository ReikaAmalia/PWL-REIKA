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
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
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
// Route::get('/', [WelcomeController::class, 'index']);
// jb 7
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka
 
 Route::get('login', [AuthController::class, 'login'])->name('login');
 Route::post('login', [AuthController::class, 'postlogin']);
 Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');
 
 Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
 
     // masukkan semua route yang perlu autentikasi di sini
     Route::get('/', [WelcomeController::class, 'index']); 
 });

//jb 5 terbaru prak 2
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    //jb 6
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax

    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    //jb 6
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //Menyimpan perubahan
    // prak 3
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax

    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']); // menyimpan data level baru
    //tugas jb 6
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data user baru Ajax

    Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data level
    //tugas jb 6
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //Menampilkan halaman
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //Menyimpan perubahan
    // tugas jb 6
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data user Ajax

    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriCotroller::class, 'index']); // menampilkan halaman awal kategori
    Route::post('/list', [KategoriCotroller::class, 'list']); // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriCotroller::class, 'create']); // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriCotroller::class, 'store']); // menyimpan data kategori baru
    //tugas jb 6
    Route::get('/create_ajax', [KategoriCotroller::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [KategoriCotroller::class, 'store_ajax']); // Menyimpan data user baru Ajax

    Route::get('/{id}', [KategoriCotroller::class, 'show']); // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriCotroller::class, 'edit']); // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriCotroller::class, 'update']); // menyimpan perubahan data kategori
     //tugas jb 6
     Route::get('/{id}/edit_ajax', [KategoriCotroller::class, 'edit_ajax']); //Menampilkan halaman
     Route::put('/{id}/update_ajax', [KategoriCotroller::class, 'update_ajax']); //Menyimpan perubahan
     // tugas jb 6
     Route::get('/{id}/delete_ajax', [KategoriCotroller::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
     Route::delete('/{id}/delete_ajax', [KategoriCotroller::class, 'delete_ajax']); // Untuk hapus data user Ajax

    Route::delete('/{id}', [KategoriCotroller::class, 'destroy']); // menghapus data kategori
});

Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']); // menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']); // menyimpan data supplier baru
    //tugas jb 6
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data user baru Ajax

    Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data supplier
    //tugas jb 6
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //Menampilkan halaman
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); //Menyimpan perubahan
    // tugas jb 6
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data user Ajax

    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
    // tugas jb 6
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data user baru Ajax

    Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data barang
     //tugas jb 6
     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman
     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); //Menyimpan perubahan
     // tugas jb 6
     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data user Ajax
     
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});