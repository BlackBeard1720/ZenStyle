<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home(){
        return view('frontend.home.index');
    }
    public function about(){
        return view('frontend.about.index');
    }
    public function news(){
        return view('frontend.news.index');
    }



}
