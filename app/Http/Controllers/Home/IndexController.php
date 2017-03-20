<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCate;
use App\Models\Post;
use App\Models\PostRelationships;

class IndexController extends Controller
{
    public function index()
    {
        return view('home/index');
    }

    public function lists(Request $request)
    {
        $slug  = $request->input('slug');
        $postCateInfo = PostCate::query()->where('slug',$slug)->first();
        if(!empty($postCateInfo)) {
            $lists = PostRelationships::where('post_cate_id',$postCateInfo['id'])->get()->toArray();
        }
        dump($lists);
        return view('home/index');
    }

    public function detail()
    {
        return view('home/detail');
    }
}