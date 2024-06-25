@extends('dashboard.layouts.app')
<style>
    .stats-card {
        margin-bottom: 1rem;
        border: 1px solid #e3e3e3;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-card .row>div {
        padding: 1rem;
        border-right: 1px solid #e3e3e3;
    }

    .stats-card .row>div:last-child {
        border-right: none;
    }

    .stats-card h5 {
        color: #555;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stats-card p {
        font-size: 1.25rem;
        color: #333;
    }

    .latest-post-card {
        margin-bottom: 1rem;
        border: 1px solid #e3e3e3;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .latest-post-card .media img {
        width: 64px;
        height: 64px;
        object-fit: cover;
    }

    .latest-post-card h5 {
        color: #333;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .latest-post-card p {
        color: #777;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        line-height: 1.5;
    }

    .view-count {
        align-items: center;
    }

    .view-count i {
        margin-left: 0.5rem;
        color: #555;
    }
</style>

@section('contents')
    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-transparent-50 overflow-hidden">
                <div class="card-header position-relative">
                    <div class="bg-holder d-none d-md-block bg-card z-1"
                        style="background-image:url(../assets/img/illustrations/ecommerce-bg.png);background-size:230px;background-position:right bottom;z-index:-1;">
                    </div>
                    <div>
                        <h3 class="text-primary mb-1">{{ Auth()->user()->name }}!</h3>
                        <p>Here’s what happening </p>
                    </div>

                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md">
                                    <h5><a href="{{ route('dashboard.blog.index') }}"><i class="fa fa-file-alt"></i>
                                            Posts</a></h5>
                                    <p class="h4">{{ $totalPosts }}</p>
                                </div>
                                <div class="col-6 col-md">
                                    <h5><a href="{{ route('dashboard.comments.index') }}"><i class="fa fa-comment"></i>
                                            Comments</a></h5>
                                    <p class="h4">{{ $totalComments }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md">
                                    <h5>All Time</h5>
                                    <p class="h4">{{ $allTimeViews }}</p>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Today</h5>
                                    <p class="h4">{{ $todayViews }}</p>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Yesterday</h5>
                                    <p class="h4">{{ $yesterdayViews }}</p>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>This Month</h5>
                                    <p class="h4">{{ $thisMonthViews }}</p>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Last Month</h5>
                                    <p class="h4">{{ $lastMonthViews }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card latest-post-card">
                        <div class="card-header">
                            Latest Post
                        </div>
                        <div class="card-body">
                            <div class="row media">
                                <div class="col-3 col-md-2">
                                    <img src="{{ asset('storage/blog/images/' . $latestPost->cover_image) }}"
                                        class="mr-3" alt="Post Image">
                                </div>
                                <div class="col-9 col-md-10 media-body">
                                    <h5 class="mt-0">{{ $latestPost->title }}</h5>
                                    <p>by Peter Odion on {{ $latestPost->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h4>{{ 'Blog Post' }}</h4>
                        <div id="posts-container">
                            @foreach ($posts as $post)
                                <a href="" class="">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3 col-md-2">
                                                    <img src="{{ asset('storage/blog/images/' . $post->cover_image) }}"
                                                        class="mr-3" alt="Post Image" style="width: 64px; height: 64px;">
                                                </div>
                                                <div class="col-6 col-md-8">
                                                    <p class="card-text">{{ $post->title }}</p>
                                                </div>
                                                <div
                                                    class="col-3 col-md-2 d-flex justify-content-end p-2 align-items-center view-count">
                                                    <span class="mr-2">{{ $post->view_count }}</span>
                                                    <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        @if ($posts->count() >= 5)
                            <div class="d-flex justify-content-end">
                                <button id="load-more-btn" class="btn btn-sm btn-primary">Load More</button>
                            </div>
                        @endif
                    </div>
                  

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentPage = 1;

            $('#load-more-btn').click(function() {
                currentPage++;
                $.ajax({
                    url: "{{ route('dashboard.load-more-posts') }}",
                    type: "GET",
                    data: {
                        page: currentPage
                    },
                    success: function(response) {
                        $('#posts-container').append(response.html);
                        if (!response.hasMore) {
                            $('#load-more-btn').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading more posts:', error);
                    }
                });
            });
        });
    </script>
@endsection
