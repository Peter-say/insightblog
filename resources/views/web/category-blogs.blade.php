@extends('web.layouts.app')

@section('contents')
    <section class="section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="col-12 mb-4">
                        <h1 class="h2 mb-4">Search results for <mark>{{ $category->name }}</mark></h1>
                    </div>
                    <div class="row mt-5">

                        @if ($category->blogs)
                            @foreach ($category->blogs as $blog)
                                <div class="col-12 col-lg-6 col-xl-6 mb-5">
                                    <article class="card h-100">
                                        <div class="post-slider slider-sm">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/blog/images/' . $blog->cover_image) }}"
                                                    class="card-img-top" alt="post-thumb">
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h3 class="h4 mb-3">
                                                <a class="post-title"
                                                    href="{{ route('post.details', $blog->slug) }}">{{ $blog->title }}</a>
                                            </h3>
                                            <ul class="card-meta list-inline mb-3">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('post.author', $blog->user->id) }}"
                                                        class="card-meta-author">
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
                                                                <li class="list-inline-item"><a
                                                                        href="#">{{ is_array($tag) ? $tag['name'] : $tag }}</a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                            </ul>
                                            <p class="flex-grow-1">{{ Str::limit($blog->body, 150) }}</p>
                                            <a href="{{ route('post.details', $blog->slug) }}"
                                                class="btn btn-outline-primary mt-auto">Read More</a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @else
                            <h4>No blog found on {{ $category->name }}</h4>
                        @endif
                    </div>
                </div>

                {{-- <div class="col-12"> --}}
                    @include('web.aside', ['categories' => $categories, 'metaKeywords' => $metaKeywords])
                {{-- </div> --}}
            </div>
        </div>
    </section>
@endsection
