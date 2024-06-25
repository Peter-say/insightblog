@foreach ($posts as $post)
<a href="" class="">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-3 col-md-2">
                    <img src="{{ asset('storage/blog/images/' . $post->cover_image) }}" class="mr-3"
                        alt="Post Image" style="width: 64px; height: 64px;">
                </div>
                <div class="col-6 col-md-8">
                    <p class="card-text">{{ $post->title }}</p>
                </div>
                <div class="col-3 col-md-2 d-flex justify-content-end p-2 align-items-center view-count">
                    <span class="mr-2">{{ $post->view_count }}</span>
                    <i class="fa fa-eye"></i>
                </div>
            </div>
        </div>
    </div>
</a>
@endforeach