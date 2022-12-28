<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home(){
        return view('site.index');
    }

    public function checkout(Request $request){
        return view('site.checkout');
    }
}
