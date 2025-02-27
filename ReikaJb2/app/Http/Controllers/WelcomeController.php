<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{   
    public function greeting(){ 
        return view('blog.hello', ['name' => 'Reika']); 
    } 
}

?>