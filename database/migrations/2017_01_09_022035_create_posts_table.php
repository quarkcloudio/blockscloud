<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建posts
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('uuid');
            $table->string('title');
            $table->string('name');
            $table->string('description');
            $table->string('password');
            $table->string('cover_path');
            $table->integer('pid');
            $table->integer('level');
            $table->string('type')->default('post')->comment('文章类型（post/page/link等）');
            $table->longText('content');
            $table->integer('comment')->default(0)->comment('评论数量');
            $table->integer('view')->default(0)->comment('浏览数量');
            $table->string('page_tpl')->comment('page类型时模板名称');
            $table->timestamps();
            $table->string('comment_status')->default('open');
            $table->tinyInteger('status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
