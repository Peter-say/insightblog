<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        // Get all active blog posts with their category, ordered by creation date
        $blogs = BlogPost::with('category')->where('status', 'active')->orderBy('created_at', 'desc')->paginate(5);

        // Get the top 4 trending posts where view count is the highest
        $trendingPosts = BlogPost::with('category')
            ->where('is_trending', true)
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        // Get the top 5 popular posts based on view count
        $popularPost = BlogPost::with('category')
            ->where('status', 'active')
            ->orderBy('view_count', 'desc')
            ->first();

        // Get the first featured post
        $featuredPost = BlogPost::with('category')
            ->where('is_featured', true)
            ->first();

        // Collect all unique meta keywords from active blog posts
        $allMetaKeywords = BlogPost::where('status', 'active')->pluck('meta_keywords');

        $metaKeywords = collect($allMetaKeywords)
            ->map(function ($keywords) {
                return explode(',', $keywords);
            })
            ->flatten()
            ->map('trim')
            ->unique()
            ->filter()
            ->values();

        // Get categories with blogs
        $categories = BlogCategory::with('blogs')->get()->filter(function ($category) {
            return $category->blogs->count() > 0;
        });

        return view('web.welcome', compact('blogs', 'trendingPosts', 'popularPost', 'featuredPost', 'metaKeywords', 'categories'));
    }
}