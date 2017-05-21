<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCate;
use App\Models\Post;
use App\Models\PostRelationships;
use App\Services\Helper;
use DB;

class IndexController extends BaseController
{
	//系统首页
    public function index()
    {
        $usersInfo = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($usersInfo->uuid,'website.config');
        return view('home/index',compact('website'));
    }
}