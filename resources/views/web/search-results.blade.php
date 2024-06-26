<div class="py-3"></div>
<section class="section" id="search-results">
    <div class="row justify-content-center">
        <div class="col-12 mb-4">
            <h1 class="h2 mb-4">Search results for <mark>{{ request('search_terms') }}</mark></h1>
        </div>
        <div class="col-lg-10">
            @if ($blogs->isNotEmpty())
                <h2>Blog Posts</h2>
                @foreach ($blogs as $blog)
                    <article class="card mb-4">
                        <div class="row card-body">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="post-slider slider-sm">
                                    <img src="{{ asset('storage/blog/images/' . $blog->cover_image) }}"
                                        class="card-img" alt="{{ $blog->cover_image }}"
                                        style="height:200px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3 class="h4 mb-3"><a class="post-title"
                                        href="{{ route('post.details', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                <ul class="card-meta list-inline">
                                    <li class="list-inline-item">
                                        <a href="{{ route('post.author', $blog->user->id) }}"
                                            class="card-meta-author">
                                            @if (!empty($blog->user->avatar))
                                                <img class="rounded-circle"
                                                    src="{{ asset('storage/user/images/' . $blog->user->avatar) }}"
                                                    alt="{{ $blog->user->name }}">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                                    alt="{{ $blog->user->name }}">
                                            @endif
                                            <span>{{ $blog->user->name }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item"><i
                                            class="ti-timer"></i>{{ $blog->calculateReadingTime() }} Min To Read
                                    </li>
                                    <li class="list-inline-item"><i
                                            class="ti-calendar"></i>{{ $blog->created_at->format('d M, Y') }}</li>
                                    <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            @if ($blog->meta_keywords)
                                                @php
                                                    $metaKeywords = is_array($blog->meta_keywords)
                                                        ? $blog->meta_keywords
                                                        : explode(',', $blog->meta_keywords);
                                                @endphp
                                                @foreach ($metaKeywords as $tag)
                                                    <li class="list-inline-item"><a
                                                            href="{{ route('post.tags', $tag) }}">{{ is_array($tag) ? $tag['name'] : $tag }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                                <p>{!! html_entity_decode( Str::limit($blog->body, 150)) !!}</p>
                                <a href="{{ route('post.details', $blog->slug) }}"
                                    class="btn btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif

            @if ($users->isNotEmpty())
                <h2>Users</h2>
                @foreach ($users as $user)
                    <article class="card mb-4">
                        <div class="row card-body">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <img src="{{ $user->avatar }}" class="card-img" alt="{{ $user->name }}">
                            </div>
                            <div class="col-md-8">
                                <h3 class="h4 mb-3"><a class="post-title"
                                        href="{{ route('user.profile', $user->id) }}">{{ $user->name }}</a></h3>
                                <p>Email: {{ $user->email }}</p>
                                <a href="{{ route('user.profile', $user->id) }}"
                                    class="btn btn-outline-primary">View Profile</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif

            @if ($blogs->isEmpty() && $users->isEmpty())
                <div class="col-12 text-center">
                    <img class="mb-5 img-fluid" src="{{ asset('web/images/no-search-found.svg') }}"
                        alt="No Search Found" style="max-width: 100%; height: auto;">
                    <h3>No Search Found</h3>
                </div>
            @endif
        </div>
    </div>
</section>
