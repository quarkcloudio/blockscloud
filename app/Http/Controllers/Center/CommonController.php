<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Cookie;
use Illuminate\Support\Facades\Auth;
use App\Permission;
use App\User;
use App\Services\Helper;
use Entrust;
use Route;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.center');
    }
}