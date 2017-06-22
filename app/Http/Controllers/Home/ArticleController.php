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

        $user = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($user->uuid,'website.config');

        $articles = DB::table('posts')
        ->leftJoin("post_relationships",'posts.id','=','post_relationships.object_id')
        ->where('posts.type', 'article')
        ->orderBy('id', 'desc')
        ->paginate(8);
        return view('home/index',compact('website','articles'));
    }

	/**
     * 文章列表页
     * @author tangtanglove
	 */
    public function lists(Request $request)
    {
        $id      = $request->input('id');
        $slug    = $request->input('slug');
        $user = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($user->uuid,'website.config');

        if (!empty($id)) {
            $postCate = DB::table('post_cates')->where('id', $id)->first();
        } elseif(!empty($slug)) {
            $postCate = DB::table('post_cates')->where('slug', $slug)->first();
        }

        $postCateExtend = Helper::getKeyValue($postCate->uuid);

        $articles = DB::table('posts')
        ->leftJoin("post_relationships",'posts.id','=','post_relationships.object_id')
        ->where('posts.type', 'article')
        ->where('post_relationships.post_cate_id', $postCate->id)
        ->orderBy('id', 'desc')
        ->paginate($postCateExtend['page_num']);

        return view('home/'.$postCateExtend['lists_tpl'],compact('website','articles','postCate'));
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

        $user = DB::table('users')->where('id', 1)->first();
        $website = Helper::getKeyValue($user->uuid,'website.config');

        if(empty($category)) {
            $getCategory = DB::table('post_relationships')->where('object_id',$id)->first();
            $category = $getCategory->post_cate_id;
        }

        $postCate = DB::table('post_cates')->where('id', $category)->first();
        $postCateExtend = Helper::getKeyValue($postCate->uuid);
        if (!empty($id)) {
            $article = DB::table('posts')->where('id', $id)->first();
        } elseif(!empty($name)) {
            $article = DB::table('posts')->where('name', $name)->first();
        } else {
            return Helper::jsonError('参数错误！');
        }

        // 浏览量自增
        DB::table('posts')->where('id', $id)->increment('view');

        return view('home/'.$postCateExtend['detail_tpl'],compact('website','article','postCate'));
    }
}