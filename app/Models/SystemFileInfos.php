<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFileInfos extends Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'system_file_infos';

    /**
     * 获取与用户关联的电话号码
     */
    public function app()
    {
        return $this->belongsTo('App\Models\Apps')->select('name', 'icon','width','height','context');
    }

}
