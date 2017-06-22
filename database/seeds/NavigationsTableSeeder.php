<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navigations')->insert([
             [
                'title' => '默认分类',
                'pid' => 0,
                'url' =>'/home/article/lists?id=1',
                'sort'=>0,
                'status'=>1
             ]
        ]);
    }
}
