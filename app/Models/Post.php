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
}
