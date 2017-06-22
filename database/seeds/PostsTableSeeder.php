<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Services\Helper;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Helper::createUuid();
        DB::table('posts')->insert([
             [
                'uid' => 1,
                'pid' => 0,
                'uuid' => $uuid,
                'title' =>'你好，世界！',
                'name'=>'hello',
                'description' => '你好，世界！',
                'type' => 'article',
                'level'=>0,
                'content' => '欢迎使用积木云！',
                'cover_path' => 'public/uploads/1.jpg',
                'password' => '',
                'page_tpl' => '',
                'status'=>1
             ]
        ]);

        DB::table('post_relationships')->insert([
             [
                'object_id' => 1,
                'post_cate_id' => 1
             ]
        ]);
    }
}
