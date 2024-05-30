@extends('dashboard.layouts.app')

@section('contents')
    <form action="{{ route('dashboard.blog.store') }}" enctype="multipart/form-data" id="blogForm" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Add a Blog</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.blog.index') }}"
                            class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>
                        <button type="submit" id="submitButton" class="btn btn-primary">Add Blog</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="title">Blog Title:</label>
                            <input name="title" id="title" type="text"
                                class="form-control @error('title') is-invalid @enderror" required placeholder="Enter Title"
                                value="{{ old('title') }}" />
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Slug:</label>
                            <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                required id="slug" placeholder="Enter Title" value="{{ old('title') }}" />
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Add Cover Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="fallback">
                                    <input name="cover_image" type="file"
                                        class="form-control @error('cover_image') is-invalid @enderror" required />
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="body">Body:</label>
                            @include('components.forms.tinymce-editor')
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="status">Status:</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="" selected disabled>Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Type</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="blog-category">Select Category:</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="blog-category"
                                    name="category_id" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Tags</h6>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="product-tags">Add Keywords:</label>
                            <input class="form-control js-choice @error('meta_keyword') is-invalid @enderror"
                                id="product-tags" type="text" name="meta_keyword[]"
                                value="{{ old('meta_keyword') ? implode(',', old('meta_keyword')) : '' }}"
                                data-options='{"removeItemButton":true,"placeholder":false}' />
                            @error('meta_keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Meta Description</h6>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="meta_description">Meta Description:</label>
                            <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" cols="30"
                                rows="5">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="published_at">Publish Date:</label>
                        <input name="published_at" id="published_at" type="date"
                            class="form-control @error('published_at') is-invalid @enderror"
                            value="{{ old('published_at') }}" />
                        @error('published_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" id="confirm_published_date" />
                        <label for="confirm_published_date">Use current date and time as publish date</label>
                    </div>


                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">You're almost done!</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.blog.index') }}"
                            class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>
                        <button type="submit" id="submitButton" class="btn btn-primary">Add Post</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        const appUrl = '{{ config('app.url') }}';
        document.getElementById('title').addEventListener('input', function() {
            let title = this.value.toLowerCase().trim();
            // Replace spaces with hyphens
            title = title.replace(/\s+/g, '-');
            // Update the slug input value
            document.getElementById('slug').value = appUrl + '/' + title;
        });

        document.getElementById('confirm_published_date').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('published_at').valueAsDate = new Date();
            } else {
                document.getElementById('published_at').value = '';
            }
        });

        // Get a reference to the form
        var form = document.getElementById('blogForm');

        // Get a reference to the TinyMCE editor instance
        var editor = tinymce.get('myeditorinstance');

        // Add an event listener to the form's submit button (assuming it has ID 'submitButton')
        document.getElementById('submitButton').addEventListener('click', function(event) {
            // Update the textarea associated with the TinyMCE editor with its current content
            editor.save();

            // Trigger the form submission
            form.submit();
        });
    </script>
@endsection
