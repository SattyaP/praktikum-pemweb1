<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'code_post', 'image', 'contents', 'excerpt'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postCategories()
    {
        return $this->hasMany(PostCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function scopePost($query, $post_id)
    {
        return $query->where('id', $post_id);
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%');
    }

    public function scopeCategory($query, $category_id)
    {
        return $query->whereHas('categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        });
    }

    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    public function scopeDraft($query)
    {
        return $query->where('published', 0);
    }

    public function scopeCountLike($query, $post_id)
    {
        return $query->where('id', $post_id)->withCount('likes')->first();
    }

    public function scopeCountDislike($query, $post_id)
    {
        return $query->where('id', $post_id)->withCount('likes')->first();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
