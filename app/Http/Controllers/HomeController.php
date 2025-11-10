<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    public function getHome(){
        return view('index');
    }

    public function discoverMorePage(){
        return view('discover_more');
    }
}
