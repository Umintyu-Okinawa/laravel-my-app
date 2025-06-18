<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment; // ← これも追加しておくと安心
use PgSql\Lob;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class); // ← ✅ 正しいメソッド名
    }


    // Post.php
public function likes()
{
    return $this->hasMany(Like::class);
}




public function user()
{
    return $this->belongsTo(User::class);
}


public function isLikedBy($user)
{
    return $this->likes()->where('user_id', $user->id)->exists();
}

}


