@extends('web.layouts.app')
@include('web.layouts.meta-data');
<style>
    .commenter-image {
        width: 100px;
        height: 100px;
    }
</style>



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
                                                    href="{{ route('post.tags', $tag) }}">{{ is_array($tag) ? $tag['name'] : $tag }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        <div class="content">{!! html_entity_decode($blog->body) !!}</div>

                </div>
                </article>


                <div class="col-lg-9 col-md-12">
                    <div class="mb-5 border-top mt-4 pt-5">
                        <h3 class="mb-4">Comments</h3>

                        @foreach ($blog->comments as $comment)
                            <div class="media d-block d-sm-flex mb-4 pb-4" id="comment-{{ $comment->id }}">
                                <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                    @if ($comment->user && !empty($comment->user->avatar))
                                        <img src="{{ asset('storage/user/avatars/' . $comment->user->avatar) }}"
                                            class="mr-3 rounded-circle commenter-image" alt="{{ $comment->user->name }}">
                                    @else
                                        <img src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                            class="mr-3 rounded-circle commenter-image" alt="Default Avatar">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <a href="#!" class="h4 d-inline-block mb-3">{{ $comment->commenter_name }}</a>
                                    <p>{{ $comment->body }}</p>
                                    <span
                                        class="text-black-800 mr-3 font-weight-600">{{ $comment->created_at->format('F d, Y \a\t h:i a') }}</span>
                                    <a class="text-primary font-weight-600 reply-btn" href="#!"
                                        data-comment-id="{{ $comment->id }}">Reply</a>

                                    <!-- Reply Form -->
                                    <form method="POST" class="reply-form" id="reply-form-{{ $comment->id }}"
                                        style="display:none;">
                                        @csrf
                                        <textarea class="form-control shadow-none" name="body" rows="3" required></textarea>
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <input type="hidden" name="post_id" value="{{ $blog->id }}">
                                        <div class="form-row">

                                            <div class="form-group col-md-4">
                                                <input class="form-control shadow-none" type="text" name="commenter_name"
                                                       placeholder="Name"
                                                       value="{{ Auth::check() ? Auth::user()->name : (Session::get('commenter_name') ?: Cookie::get('commenter_name') ?: old('commenter_name')) }}"
                                                       {{ Auth::check() || Session::has('commenter_name') || Cookie::has('commenter_name') ? 'readonly' : 'required' }}>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-control shadow-none" type="email" name="commenter_email"
                                                       placeholder="Email"
                                                       value="{{ Auth::check() ? Auth::user()->email : (Session::get('commenter_email') ?: Cookie::get('commenter_email') ?: old('commenter_email')) }}"
                                                       {{ Auth::check() || Session::has('commenter_email') || Cookie::has('commenter_email') ? 'readonly' : 'required' }}>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-control shadow-none" type="url" name="commenter_website"
                                                       placeholder="Website"
                                                       value="{{ Auth::check() ? Auth::user()->website : (Session::get('commenter_website') ?: Cookie::get('commenter_website') ?: old('commenter_website')) }}">
                                            </div>
                                            


                                        </div>
                                        <button class="btn btn-primary mt-2" type="submit">Reply</button>
                                        <button class="btn btn-danger mt-2 ml-2 cancel-reply-btn">Cancel</button>
                                    </form>

                                    <!-- Replies -->
                                    @foreach ($comment->replies as $reply)
                                        <div class="media d-block d-sm-flex mt-4">
                                            <div class="d-inline-block mr-2 mb-3 mb-md-0">
                                                <img class="mr-3" src="{{ asset('web/images/post/arrow.png') }}"
                                                    alt="">
                                                <a href="#" class="card-meta-author">
                                                    @if ($reply->user && !empty($reply->user->avatar))
                                                        <img class="rounded-circle commenter-image"
                                                            src="{{ asset('storage/user/avatars/' . $reply->user->avatar) }}"
                                                            alt="{{ $reply->commenter_name }}"
                                                            style="width: 100px; height: 100px;" />
                                                    @else
                                                        <img class="rounded-circle commenter-image"
                                                            src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                                            alt="Default Avatar" style="width: 100px; height: 100px;" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#!"
                                                    class="h4 d-inline-block mb-3">{{ $reply->commenter_name }}</a>
                                                <p>{{ $reply->body }}</p>
                                                <span
                                                    class="text-black-800 mr-3 font-weight-600">{{ $reply->created_at->format('F d, Y \a\t h:i a') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h3 class="mb-4">Leave a Reply</h3>
                        <form method="POST" id="comment-form" action="{{ route('post.comments.store', $blog->id) }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $blog->id }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control shadow-none" name="body" rows="7" required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control shadow-none" type="text" name="commenter_name"
                                           placeholder="Name"
                                           value="{{ Auth::check() ? Auth::user()->name : (Session::get('commenter_name') ?: Cookie::get('commenter_name') ?: old('commenter_name')) }}"
                                           {{ Auth::check() || Session::has('commenter_name') || Cookie::has('commenter_name') ? 'readonly' : 'required' }}>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control shadow-none" type="email" name="commenter_email"
                                           placeholder="Email"
                                           value="{{ Auth::check() ? Auth::user()->email : (Session::get('commenter_email') ?: Cookie::get('commenter_email') ?: old('commenter_email')) }}"
                                           {{ Auth::check() || Session::has('commenter_email') || Cookie::has('commenter_email') ? 'readonly' : 'required' }}>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control shadow-none" type="url" name="commenter_website"
                                           placeholder="Website"
                                           value="{{ Auth::check() ? Auth::user()->website : (Session::get('commenter_website') ?: Cookie::get('commenter_website') ?: old('commenter_website')) }}">
                                </div>
                                

                            </div>
                            <button class="btn btn-primary" type="submit">Comment Now</button>
                        </form>
                    </div>
                </div>




            </div>
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
                                                    <img class="rounded-circle "
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
                                            <i class="ti-timer"></i>{{ $relatedPost->calculateReadingTime() }} Min
                                            To
                                            Read
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
    </section>


    <script>
        window.addEventListener('load', function() {

            // Show reply form
            $(document).on('click', '.reply-btn', function(e) {
                e.preventDefault();
                var commentId = $(this).data('comment-id');
                $('#reply-form-' + commentId).toggle();
            });
            // Cancel reply
            $(document).on('click', '.cancel-reply-btn', function(e) {
                e.preventDefault();
                $(this).closest('.reply-form').hide();
            });
            // Submit comment
            $('#comment-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('post.comments.store', $blog->id) }}',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Format the date using JavaScript Date object
                            // Parse date if needed
                            var createdAt = new Date(response.comment.created_at);
                            var formattedDate = createdAt.toLocaleString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true
                            });

                            // Check if the user has an avatar or use default avatar
                            var avatarUrl = response.comment.user && response.comment.user
                                .avatar ?
                                '{{ asset('storage/user/avatars/') }}' + '/' + response.comment
                                .user.avatar :
                                '{{ asset('dashboard/assets/img/team/avatar.png') }}';

                            // Append new comment to DOM
                            $('.mb-5.border-top.mt-4.pt-5').append(
                                `<div class="media d-block d-sm-flex mb-4 pb-4" id="comment-${response.comment.id}">
                <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                    <img src="${avatarUrl}" class="mr-3 rounded-circle commenter-image" alt="${response.comment.user ? response.comment.user.name : 'Guest'}">
                </a>
                <div class="media-body">
                    <a href="#!" class="h4 d-inline-block mb-3">${response.comment.commenter_name}</a>
                    <p>${response.comment.body}</p>
                    <span class="text-black-800 mr-3 font-weight-600">${formattedDate}</span>
                    <a class="text-primary font-weight-600 reply-btn" href="#!" data-comment-id="${response.comment.id}">Reply</a>
                    
                    <form method="POST" class="reply-form" id="reply-form-${response.comment.id}" style="display:none;">
                        @csrf
                        <textarea class="form-control shadow-none" name="body" rows="3" required></textarea>
                        <input type="hidden" name="parent_id" value="${response.comment.id}">
                        <input type="hidden" name="post_id" value="${response.comment.post_id}">
                        
                        @if (!Auth::check())
                        <div class="form-group col-md-4">
                            <input class="form-control shadow-none" type="text" name="commenter_name" placeholder="Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <input class="form-control shadow-none" type="email" name="commenter_email" placeholder="Email" required>
                        </div>
                        @endif

                        <div class="form-group col-md-4">
                            <input class="form-control shadow-none" type="url" name="commenter_website" placeholder="Website">
                        </div>
                        <button class="btn btn-primary mt-2" type="submit">Reply</button>
                    </form>
                </div>
            </div>`
                            );

                            // Show success message using custom popup
                            showPopup('success', 'Comment submitted successfully.');

                            // Reset form
                            form.trigger("reset");
                        } else {
                            showPopup('error', response.message);
                        }
                    },

                    error: function(response) {
                        showPopup('error', 'Failed to submit comment.');
                    }
                });
            });

            // Submit reply
            $(document).on('submit', '.reply-form', function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('post.comments.store', $blog->id) }}',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Append new reply to DOM
                            form.before(
                                `<div class="media d-block d-sm-flex mt-4">
                                <div class="d-inline-block mr-2 mb-3 mb-md-0">
                                    <a href="#"><img src="images/post/user-02.jpg" class="mr-3 rounded-circle" alt=""></a>
                                </div>
                                <div class="media-body">
                                    <a href="#!" class="h4 d-inline-block mb-3">${response.comment.commenter_name}</a>
                                    <p>${response.comment.body}</p>
                                    <span class="text-black-800 mr-3 font-weight-600">${response.comment.created_at}</span>
                                </div>
                            </div>`
                            );

                            // Hide reply form
                            form.hide();

                            // Show success message using custom popup
                            showPopup('success', 'Reply submitted successfully.');

                            // Reset form
                            form.trigger("reset");
                        } else {
                            showPopup('error', response.message);
                        }
                    },
                    error: function(response) {
                        showPopup('error', 'Failed to submit reply.');
                    }
                });
            });

            // Function to show custom popup
            function showPopup(type, message) {
                // Check if popup already exists
                var popup = $('#popup-message');
                if (popup.length === 0) {
                    // Append popup to body if not exists
                    $('body').append(`<div id="popup-message" class="popup-message ${type}">
                                    <div class="d-flex justify-content-around">
                                        <p class="text-white">${message}</p>
                                        <span id="cancel-popup">X</span>
                                    </div>
                                </div>`);
                    popup = $('#popup-message');
                } else {
                    // Update existing popup
                    popup.removeClass().addClass(`popup-message ${type}`)
                        .find('p').html(message);
                }

                // Show the popup
                popup.fadeIn();

                // Automatically hide the popup after 8 seconds
                setTimeout(function() {
                    popup.fadeOut();
                }, 8000);

                // Bind close popup function to close button
                $('#cancel-popup').on('click', function() {
                    popup.fadeOut();
                });
            }
        });
    </script>


@endsection
