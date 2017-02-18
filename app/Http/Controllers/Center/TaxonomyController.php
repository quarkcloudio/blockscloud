<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;

class TaxonomyController extends CommonController
{
    public function index()
    {
        return view('center/index');
    }
}