<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function posts(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
