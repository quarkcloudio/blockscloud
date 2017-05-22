<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigations extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    // protected $table = 'default_open';
    protected $fillable = [
        'title',
        'pid',
        'url',
        'sort',
        'status',
    ];


}
