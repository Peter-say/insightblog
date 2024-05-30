@extends('dashboard.layouts.app')

@section('contents')
    <form action="{{ route('dashboard.blog.update', $blog->id) }}" enctype="multipart/form-data" id="blogForm" method="POST">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Edit Blog</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.blog.index') }}"
                            class="btn btn-link text-secondary p-0 me-3 fw-medium">Discard</a>
                        <button type="submit" id="submitButton" class="btn btn-primary">Update Blog</button>
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
                                value="{{ old('title', $blog->title) }}" />
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug">Slug:</label>
                            <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                required id="slug" placeholder="Enter Slug" value="{{ old('slug', $blog->slug) }}" />
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
                                        class="form-control @error('cover_image') is-invalid @enderror" />
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($blog->cover_image)
                                        <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="Cover Image"
                                            class="img-fluid mt-2">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="body">Body:</label>
                            @include('components.forms.tinymce-editor', [
                                'body' => old('body', $blog->body),
                            ])
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
                                <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ old('status', $blog->status) == 'inactive' ? 'selected' : '' }}>Inactive
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
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
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
                            <label class="form-label" for="product-tags">Add Keywords: (<small>seperate each with a
                                    comma</small>)</label>
                            <input class="form-control js-choice @error('meta_keyword') is-invalid @enderror"
                                id="product-tags" type="text" name="meta_keyword[]"
                                value="{{ is_array(old('meta_keyword', $blog->meta_keyword)) ? implode(',', old('meta_keyword', $blog->meta_keyword)) : (is_array($blog->meta_keyword) ? implode(',', $blog->meta_keyword) : $blog->meta_keyword) }}"
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
                            <label class="form-label" for="meta_description">Meta Description:(<small>Make it between 180
                                    chars</small>)</label>
                            <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" cols="30"
                                rows="5">{{ old('meta_description', $blog->meta_description) }}</textarea>
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
                            value="{{ old('published_at', $blog->published_at ? substr($blog->published_at, 0, 10) : '') }}" />
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
                        <button type="submit" id="submitButton" class="btn btn-primary">Update Post</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        window.addEventListener('load', function() {
            const appUrl = '{{ config('app.url') }}';
            const slugInput = document.getElementById('slug');
            const oldSlug = slugInput.value;

            // Function to check if the slug already contains the app URL
            function hasAppUrl(slug) {
                return slug.startsWith(appUrl);
            }

            // Function to generate the new slug
            function generateSlug(title) {
                return appUrl + '/' + title.toLowerCase().trim().replace(/\s+/g, '-');
            }

            // Prefill the slug input when the page loads
            if (!hasAppUrl(oldSlug)) {
                const titleInput = document.getElementById('title');
                const newSlug = generateSlug(titleInput.value);
                slugInput.value = newSlug;
            }

            // Update the slug input value as the user types in the title input
            document.getElementById('title').addEventListener('input', function() {
                const newSlug = generateSlug(this.value);
                slugInput.value = newSlug;
            });
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
