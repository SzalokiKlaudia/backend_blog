<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    /** @use HasFactory<\Database\Factories\PictureFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'path'
    ];

    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
