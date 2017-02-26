<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建posts_cates
        Schema::create('post_cates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('pid');
            $table->string('name');
            $table->string('slug')->comment('分类缩略名');
            $table->string('taxonomy')->comment('分类方法(category/tags)');
            $table->string('description')->comment('分类描述');
            $table->integer('count')->default(0)->comment('文章数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_cates');
    }
}
