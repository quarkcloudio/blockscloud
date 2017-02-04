<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemFileInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建system_file_infos
        Schema::create('system_file_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('file_type');
            $table->string('file_icon');
            $table->integer('app_id');
            $table->string('context');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system_file_infos');
    }
}
