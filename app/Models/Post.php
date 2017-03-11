<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'uid',
        'pid',
        'uuid',
        'name',
        'title',
        'cover_path',
        'description',
        'content',
        'password',
        'status',
        'level',
        'type',
        'comment',
        'view',
    ];
}
