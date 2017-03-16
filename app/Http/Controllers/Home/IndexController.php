<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('home/index');
    }

    public function detail()
    {
        return view('home/detail');
    }
}