@extends('web.layouts.app')

@section('contents')
    <section class="section">
        <div class="py-4"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8  mb-5 mb-lg-0">
                    <h1 class="h2 mb-4">Showing items from <mark>{{ $tag }}</mark></h1>
                    @foreach ($blogs as $blog)
                        <article class="card mb-4">
                            <div class="post-slider">
                                <img src="{{ asset('storage/blog/images/' . $blog->cover_image) }}"
                                    class="card-img-top card-img recent-blog-img" alt="{{ $blog->cover_image }}">
                            </div>
                            <div class="card-body">
                                <h3 class="mb-3">
                                    <a class="post-title"
                                        href="{{ route('post.details', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <ul class="card-meta list-inline">
                                    <li class="list-inline-item">
                                        <a href="{{ route('post.author', $blog->user->id) }}" class="card-meta-author">
                                            @if (!empty($blog->user->avatar))
                                                <img class="rounded-circle"
                                                    src="{{ asset('storage/user/images/' . $blog->user->avatar) }}"
                                                    alt="" />
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                                    alt="" />
                                            @endif
                                            <span>{{ $blog->user->name }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ti-timer"></i>{{ $blog->calculateReadingTime() }} Min To Read
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ti-calendar"></i>{{ $blog->created_at->format('d M, Y') }}
                                    </li>
                                    <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            @if ($blog->meta_keywords)
                                                @php
                                                    $metaKeywords = is_array($blog->meta_keywords)
                                                        ? $blog->meta_keywords
                                                        : explode(',', $blog->meta_keywords);
                                                @endphp
                                                @foreach ($metaKeywords as $tag)
                                                    <li class="list-inline-item">
                                                        <a href="#">{{ is_array($tag) ? $tag['name'] : $tag }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                                <p>{!! html_entity_decode( Str::limit($blog->body, 150)) !!}</p>
                                <a href="{{ route('post.details', $blog->slug) }}" class="btn btn-outline-primary">Read
                                    More</a>
                            </div>
                        </article>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        <h4>That's All</h4>
                    </div>
                </div>
                @include('web.aside', ['categories' => $categories])
            </div>
    </section>
@endsection
