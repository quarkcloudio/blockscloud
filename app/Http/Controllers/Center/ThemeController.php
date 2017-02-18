<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;

class ThemeController extends CommonController
{
    public function index()
    {
        return view('center/index');
    }
}