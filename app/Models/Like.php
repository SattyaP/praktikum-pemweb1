<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'post_likes';

    protected $fillable = ['user_id', 'post_id', 'like'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePost($query, $post_id)
    {
        return $query->where('post_id', $post_id);
    }

    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeLike($query)
    {
        return $query->where('like', 1);
    }

    public function scopeDislike($query)
    {
        return $query->where('like', 0);
    }

    public function scopeCountLike($query, $post_id)
    {
        return $query->where('post_id', $post_id)->where('like', 1)->count();
    }

    public function scopeCountDislike($query, $post_id)
    {
        return $query->where('post_id', $post_id)->where('like', 0)->count();
    }

    public function scopeCheckLike($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->where('like', 1)->count();
    }

    public function scopeCheckDislike($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->where('like', 0)->count();
    }

    public function scopeCheckLikeDislike($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->count();
    }

    public function scopeUpdateLike($query, $post_id, $user_id, $like)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->update(['like' => $like]);
    }

    public function scopeDeleteLike($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->delete();
    }

    public function scopeDeleteLikeDislike($query, $post_id)
    {
        return $query->where('post_id', $post_id)->delete();
    }

    public function scopeDeleteLikeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id)->delete();
    }

    public function scopeDeletePost($query, $post_id)
    {
        return $query->where('post_id', $post_id)->delete();
    }

    public function scopeDeleteUser($query, $user_id)
    {
        return $query->where('user_id', $user_id)->delete();
    }

    public function scopeDeletePostUser($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->delete();
    }

    public function scopeDeletePostUserLike($query, $post_id, $user_id, $like)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->where('like', $like)->delete();
    }

    public function scopeDeletePostUserDislike($query, $post_id, $user_id, $like)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->where('like', $like)->delete();
    }

    public function scopeDeletePostUserLikeDislike($query, $post_id, $user_id)
    {
        return $query->where('post_id', $post_id)->where('user_id', $user_id)->delete();
    }

    public function scopeDeletePostLike($query, $post_id, $like)
    {
        return $query->where('post_id', $post_id)->where('like', $like)->delete();
    }

    public function scopeDeletePostDislike($query, $post_id, $like)
    {
        return $query->where('post_id', $post_id)->where('like', $like)->delete();
    }
}
