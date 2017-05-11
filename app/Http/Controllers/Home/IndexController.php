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
    public function index()
    {
        $usersInfo = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($usersInfo->uuid,'website.config');
        return view('home/index',compact('website'));
    }

    public function lists(Request $request)
    {
        $slug  = $request->input('slug');
        $postCateInfo = PostCate::query()->where('slug',$slug)->first();
        if(!empty($postCateInfo)) {
            $lists = PostRelationships::where('post_cate_id',$postCateInfo['id'])->get()->toArray();
        }
        return view('home/index');
    }

    public function detail()
    {
        return view('home/detail');
    }
}