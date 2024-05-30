<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'body', 'status', 'moderated_at'];

    public function post()
    {
        return $this->belongsTo(blogPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
