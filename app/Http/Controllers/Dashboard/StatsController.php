<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\ViewCount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfToday = Carbon::now()->startOfDay();
        $endOfToday = Carbon::now()->endOfDay();
        $startOfYesterday = Carbon::yesterday()->startOfDay();
        $endOfYesterday = Carbon::yesterday()->endOfDay();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
    
        // Fetch the data
        $allTimeViews = ViewCount::count();
        $todayViews = ViewCount::whereBetween('created_at', [$startOfToday, $endOfToday])->count();
        $yesterdayViews = ViewCount::whereBetween('created_at', [$startOfYesterday, $endOfYesterday])->count();
        $thisMonthViews = ViewCount::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $lastMonthViews = ViewCount::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
    
        $totalComments = BlogComment::count();
        $totalPosts = BlogPost::count();

        $posts = BlogPost::where('status', 'active')->orderBy('view_count', 'desc')->take(5)
        ->get();
        $latestPost = BlogPost::orderBy('created_at', 'desc')->first();
        return view('dashboard.stats.index', [
            'allTimeViews' => $allTimeViews,
            'todayViews' => $todayViews,
            'yesterdayViews' => $yesterdayViews,
            'thisMonthViews' => $thisMonthViews,
            'lastMonthViews' => $lastMonthViews,
            'totalComments' => $totalComments,
            'totalPosts' => $totalPosts,
            'latestPost' => $latestPost,
            'posts' => $posts,
        ]);
    }

    public function loadMorePosts(Request $request)
    {
        $page = $request->input('page');
        $posts = BlogPost::where('status', 'active')
            ->orderBy('view_count', 'desc')
            ->skip(($page - 1) * 5)
            ->take(5)
            ->get();

        $html = view('dashboard.stats.load-more-post', compact('posts'))->render();
        $hasMore = BlogPost::where('status', 'active')->count() > $page * 5;

        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }
    
}
