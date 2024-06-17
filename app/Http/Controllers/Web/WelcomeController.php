<?php

namespace App\Http\Controllers\Web;

use App\Helpers\PageMetaData;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $metaData = PageMetaData::welcome();
        // Get all active blog posts with their cametaDatategory, ordered by creation date
        $blogs = BlogPost::with('category')->where('status', 'active')->orderBy('created_at', 'desc')->paginate(5);

        // Get the top 4 trending posts where view count is the highest
        $trendingPosts = BlogPost::with('category')
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        // If no trending posts are found, get the top 4 posts with the highest view counts
        if ($trendingPosts->isEmpty()) {
            $trendingPosts = BlogPost::with('category')
                ->take(4)
                ->get();
        }

        // Get the most popular post based on view count
        $popularPost = BlogPost::with('category')
            ->where('status', 'active')
            ->orderBy('view_count', 'desc')
            ->first();

        // If no active post is found, get the post with the highest view count
        if (!$popularPost) {
            $popularPost = BlogPost::with('category')
                ->first();
        }

        // Get the first featured post
        $featuredPost = BlogPost::with('category')
            ->where('is_featured', true)
            ->first();

        // If no featured post is found, get the first post
        if (!$featuredPost) {
            $featuredPost = BlogPost::with('category')
                ->first();
        }

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

        return view('web.welcome', compact('blogs', 'trendingPosts', 'metaData', 'popularPost', 'featuredPost', 'metaKeywords', 'categories'));
    }

    public function searchPage()
    {
        return view('web.layouts.search-page');
    }

   public function search(Request $request)
   {

    $searchTerm = $request->get('search_terms');

    // Search blog posts
    $blogs = BlogPost::with('category')
        ->where('title', 'LIKE', "%{$searchTerm}%")
        ->orWhereHas('category', function($query) use ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        })
        ->get();

    // Search users
    $users = User::where('name', 'LIKE', "%{$searchTerm}%")
        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
        ->get();

        return response()->json([
            'html' => view('web.search-results', compact('blogs', 'users'))->render(),
        ]);

       
   }
}
