<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCate extends Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'slug',
        'pid',
        'uuid',
        'taxonomy',
        'description'
    ];
}
