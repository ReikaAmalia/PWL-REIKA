<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [PageController::class, 'index']);
// Route::get('/', function(){
//     return 'halo';
// });

Route::get('/hello', 
[WelcomeController::class,'hello']);

Route::get('/world', function () {
    return 'World';
});

Route::get('/selamat', function () {
    return 'Selamat Datang';
});

Route::get('/about', function () {
    return '2341720173-Reika Amalia S';
});

Route::get('/world', function () {
    return 'World';
});

Route::get('/user/{name} ', function ($name) {
    return 'Nama saya '.$name; 
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/articles/{id}', function ($Id) {
    return 'Halaman Artikel dengan ID '.$Id;
});

Route::get('/user/{name?}', function ($name='John') {
    return 'Nama saya '.$name;
});

// Route::get('/user/profile', function () {
//     // 
// })->name ('profile');

// Route::get( 
//     '/user/profile', 
//     [UserProfileController::class, 'show'] 
// )->name('profile'); 

// $url = route('profile'); 
// return redirect()->route('profile'); 