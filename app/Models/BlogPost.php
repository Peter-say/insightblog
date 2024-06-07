<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug', 'body', 'cover_image', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords', 'status', 'is_featured', 'is_trending'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id')->whereNull('parent_id')->with('replies'); // Only fetch top-level comments with their replies
    }

   public function calculateReadingTime()
{
    $wordCount = str_word_count(strip_tags($this->body));
    $minutesToRead = ceil($wordCount / 200); // assuming 200 words per minute
    return $minutesToRead;
}
}
