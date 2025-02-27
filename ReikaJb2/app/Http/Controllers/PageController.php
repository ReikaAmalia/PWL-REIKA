<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return 'Selamat Datang';
    }

    public function about(){
        return 'Reika Amalia S-2341720173';
    }

    public function articles(){
        return 'Halaman Artikel dengan Id:';
    }
}
