<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCate;
use App\Models\Post;
use App\Models\PostRelationships;
use App\Services\Helper;
use DB;

class ArticleController extends BaseController
{
	/**
     * 文章主题页
     * @author tangtanglove
	 */
    public function index(Request $request)
    {
        $usersInfo = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($usersInfo->uuid,'website.config');
        return view('home/index',compact('website'));
    }

	/**
     * 文章列表页
     * @author tangtanglove
	 */
    public function lists(Request $request)
    {
        $id      = $request->input('id');
        $slug    = $request->input('slug');
        $usersInfo = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($usersInfo->uuid,'website.config');

        if (!empty($id)) {
            $postCatesInfo = DB::table('post_cates')->where('id', $id)->first();
        } elseif(!empty($slug)) {
            $postCatesInfo = DB::table('post_cates')->where('slug', $slug)->first();
        }

        $postCatesExtend = Helper::getKeyValue($postCatesInfo->uuid);

        $lists = DB::table('posts')
        ->leftJoin("post_relationships",'posts.id','=','post_relationships.object_id')
        ->where('posts.type', 'article')
        ->where('post_relationships.post_cate_id', $postCatesInfo->id)
        ->paginate($postCatesExtend['page_num']);

        return view('home/'.$postCatesExtend['lists_tpl'],compact('website','lists','postCatesInfo'));
    }

	/**
     * 文章详情页
     * @author tangtanglove
	 */
    public function detail(Request $request)
    {
        $id      = $request->input('id');
        $name    = $request->input('name');
        $category      = $request->input('category');

        $usersInfo = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($usersInfo->uuid,'website.config');
        $postCatesInfo = DB::table('post_cates')->where('id', $category)->first();
        $postCatesExtend = Helper::getKeyValue($postCatesInfo->uuid);
        if (!empty($id)) {
            $info = DB::table('posts')->where('id', $id)->first();
        } elseif(!empty($name)) {
            $info = DB::table('posts')->where('name', $name)->first();
        } else {
            return Helper::jsonError('参数错误！');
        }

        return view('home/'.$postCatesExtend['detail_tpl'],compact('website','info','postCatesInfo'));
    }
}