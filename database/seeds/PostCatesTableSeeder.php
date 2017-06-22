<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Services\Helper;

class PostCatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Helper::createUuid();
        DB::table('post_cates')->insert([
             [
                'uuid' => $uuid,
                'pid' =>'0',
                'name'=>'默认分类',
                'slug' => 'default',
                'taxonomy' => 'category',
                'description' => '默认分类'
             ]
        ]);

        $extend['lists_tpl'] = 'lists';
        $extend['detail_tpl'] = 'detail';
        $extend['page_num'] = 10;

        Helper::addKeyValue('post_cates.extend',$uuid,$extend);
    }
}
