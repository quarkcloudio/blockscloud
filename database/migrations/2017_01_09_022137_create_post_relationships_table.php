<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建posts_cates
        Schema::create('post_relationships', function (Blueprint $table) {
            $table->integer('object_id')->default(0)->comment('对应文章ID/链接ID');
            $table->integer('post_cate_id')->default(0)->comment('对应分类方法ID');
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_relationships');
    }
}
