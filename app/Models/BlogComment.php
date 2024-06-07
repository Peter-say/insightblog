<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'commenter_name',
        'commenter_email',
        'commenter_website',
        'body',
        'parent_id',
        'status',
        'moderated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->with('user');
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }
}
