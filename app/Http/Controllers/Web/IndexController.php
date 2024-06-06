<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function details($slug)
{
    // Fetch the current blog post
    $blog = BlogPost::with('category')->where('slug', $slug)->firstOrFail();

    // Increment the view count
    $blog->increment('view_count');

    // Fetch related posts
    $relatedPosts = BlogPost::where('category_id', $blog->category_id)
        ->where('id', '!=', $blog->id)
        ->take(6)
        ->get();

    return view('web.details', compact('blog', 'relatedPosts'));
}


    public function tags()
    {
        //
    }

    public function author()
    {
        //
    }
}
