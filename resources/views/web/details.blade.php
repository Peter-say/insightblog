@extends('web.layouts.app')


@section('contents')

    <div class="py-4"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-9   mb-5 mb-lg-0">
                    <article>
                        <div class="post-slider mb-4">
                            <img src="{{ asset('storage/blog/images/' . $blog->cover_image) }}"
                                class="card-img-top card-img recent-blog-img" alt="{{ $blog->cover_image }}">
                        </div>

                        <h1 class="h2">{{ $blog->title }} </h1>
                        <ul class="card-meta my-3 list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route('post.author', $blog->user->id) }}" class="card-meta-author">
                                    @if (!empty($blog->user->avatar))
                                        <img class="rounded-circle"
                                            src="{{ asset('storage/user/images/' . $blog->user->avatar) }}"
                                            alt="" />
                                    @else
                                        <img class="rounded-circle"
                                            src="{{ asset('dashboard/assets/img/team/avatar.png') }}" alt="" />
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
                        <div class="content">{!! html_entity_decode($blog->body) !!}</div>

                </div>
                </article>

            </div>

            <div class="col-lg-9 col-md-12">
                <div class="mb-5 border-top mt-4 pt-5">
                    <h3 class="mb-4">Comments</h3>

                    <div class="media d-block d-sm-flex mb-4 pb-4">
                        <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                            <img src="web/images/post/user-01.jpg" class="mr-3 rounded-circle" alt="">
                        </a>
                        <div class="media-body">
                            <a href="#!" class="h4 d-inline-block mb-3">Alexender Grahambel</a>

                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce
                                condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </p>

                            <span class="text-black-800 mr-3 font-weight-600">April 18, 2020 at 6.25 pm</span>
                            <a class="text-primary font-weight-600" href="#!">Reply</a>
                        </div>
                    </div>
                    <div class="media d-block d-sm-flex">
                        <div class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                            <img class="mr-3" src="web/images/post/arrow.png" alt="">
                            <a href="#!"><img src="web/images/post/user-02.jpg" class="mr-3 rounded-circle"
                                    alt=""></a>
                        </div>
                        <div class="media-body">
                            <a href="#!" class="h4 d-inline-block mb-3">Nadia Sultana Tisa</a>

                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce
                                condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </p>

                            <span class="text-black-800 mr-3 font-weight-600">April 18, 2020 at 6.25 pm</span>
                            <a class="text-primary font-weight-600" href="#!">Reply</a>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="mb-4">Leave a Reply</h3>
                    <form method="POST">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control shadow-none" name="comment" rows="7" required></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <input class="form-control shadow-none" type="text" placeholder="Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input class="form-control shadow-none" type="email" placeholder="Email" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input class="form-control shadow-none" type="url" placeholder="Website">
                                <p class="font-weight-bold valid-feedback">OK! You can skip this field.</p>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Comment Now</button>
                    </form>
                </div>
            </div>
          <div>
            <div class="d-flex justify-content-center">
                <h2>Related Posts</h2>
            </div>
            <div class="row mt-5">

                @if ($relatedPosts)
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="col-lg-4 mb-5">

                            <article class="card h-100">
                                <div class="post-slider slider-sm">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/blog/images/' . $relatedPost->cover_image) }}"
                                            class="card-img-top" alt="post-thumb">
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="h4 mb-3">
                                        <a class="post-title"
                                            href="{{ route('post.details', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                    </h3>
                                    <ul class="card-meta list-inline mb-3">
                                        <li class="list-inline-item">
                                            <a href="{{ route('post.author', $relatedPost->user->id) }}"
                                                class="card-meta-author">
                                                @if (!empty($relatedPost->user->avatar))
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/user/images/' . $relatedPost->user->avatar) }}"
                                                        alt="" />
                                                @else
                                                    <img class="rounded-circle"
                                                        src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                                        alt="" />
                                                @endif
                                                <span>{{ $relatedPost->user->name }}</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="ti-timer"></i>{{ $relatedPost->calculateReadingTime() }} Min To Read
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="ti-calendar"></i>{{ $relatedPost->created_at->format('d M, Y') }}
                                        </li>
                                        <li class="list-inline-item">
                                            <ul class="card-meta-tag list-inline">
                                                @if ($relatedPost->meta_keywords)
                                                    @php
                                                        $metaKeywords = is_array($relatedPost->meta_keywords)
                                                            ? $relatedPost->meta_keywords
                                                            : explode(',', $relatedPost->meta_keywords);
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
                                    <p class="flex-grow-1">{{ Str::limit($relatedPost->body, 150) }}</p>
                                    <a href="{{ route('post.details', $relatedPost->slug) }}"
                                        class="btn btn-outline-primary mt-auto">Read More</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @endif
            </div>
          </div>

        </div>
        </div>
    </section>

@endsection
