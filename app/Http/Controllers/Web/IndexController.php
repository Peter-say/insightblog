<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function details($slug)
    {
        $blog = BlogPost::findOrFail('slug', $slug);
        $blog->increment('view_count');
        return view('web.details');
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
