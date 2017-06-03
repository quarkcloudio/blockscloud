<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCate;
use App\Models\Post;
use App\Models\PostRelationships;
use App\Services\Helper;
use DB;

class PageController extends BaseController
{
	/**
     * 单页
     * @author tangtanglove
	 */
    public function index(Request $request)
    {
        $id      = $request->input('id');
        $name    = $request->input('name');

        $user = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($user->uuid,'website.config');
        if (!empty($id)) {
            $page = DB::table('posts')->where('id', $id)->where('type', 'page')->first();
        } elseif(!empty($name)) {
            $page = DB::table('posts')->where('name', $name)->where('type', 'page')->first();
        } else {
            return Helper::jsonError('参数错误！');
        }

        // 浏览量自增
        DB::table('posts')->where('id', $id)->increment('view');

        return view('home/'.$page->page_tpl,compact('website','page'));
    }
}