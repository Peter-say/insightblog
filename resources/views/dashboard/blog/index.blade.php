@extends('dashboard.layouts.app')

@section('contents')
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <h4> Blog List</h4>
               <div class="d-flex justify-content-end">
                <a href="{{route('dashboard.blog.create')}}" class="btn btn-primary btn-sm">Add New</a>
               </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">
                <div class="tab-pane preview-tab-pane active" role="tabpanel"
                    aria-labelledby="tab-dom-59132dfe-b653-4a39-8aa6-28f8c9a8d67d"
                    id="dom-59132dfe-b653-4a39-8aa6-28f8c9a8d67d">
                    <div class="d-flex justify-content-around text-center mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="search_blogs">Search by category, title, or body</label>
                                <input class="form-control" type="text" name="search_blogs" id="search_blogs"
                                    placeholder="Start typing...">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive scrollbar">
                        <table id="blogs-table" class="table table-hover table-striped overflow-hidden">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Cover Image</th>
                                    <th class="text-nowrap">Category</th>
                                    <th class="text-nowrap">Title</th>
                                    <th class="text-nowrap">Body</th>
                                    <th class="text-nowrap">Published At</th>
                                    <th class="text-nowrap">View Count</th>
                                    <th class="text-nowrap">Is Trending</th>
                                    <th class="text-nowrap">Is Featured</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($blogs->count())
                                    @foreach ($blogs as $blog)
                                        <tr class="align-middle">
                                            <td class="text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('storage/blog/images/' . $blog->cover_image) }}"
                                                            alt="" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">{{ $blog->category->name }}</td>
                                            <td class="text-nowrap">{{ $blog->title }}</td>
                                            <td class="text-nowrap">{{ Str::limit(html_entity_decode(strip_tags($blog->body)), 50) }}</td>

                                            <td class="text-nowrap">
                                                {{ $blog->published_at ?? 'N/A' }}</td>
                                            <td class="text-nowrap">{{ $blog->view_count }}</td>
                                            <td class="text-nowrap">{{ $blog->is_trending ? 'Yes' : 'No' }}</td>
                                            <td class="text-nowrap">{{ $blog->is_featured ? 'Yes' : 'No' }}
                                                @if (auth()->user()->role === 'Admin' || auth()->user()->role === 'Moderator')
                                                    <form class="featured-form" method="POST"
                                                        action="{{ route('dashboard.blog.featured', $blog->id) }}">
                                                        @csrf @method('PUT')
                                                        <label>
                                                            <input type="radio" name="is_featured" value="1"
                                                                {{ $blog->is_featured ? 'checked' : '' }}> Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="is_featured" value="0"
                                                                {{ !$blog->is_featured ? 'checked' : '' }}> No
                                                        </label>
                                                        <button type="submit">Update</button>
                                                    </form>
                                            </td>
                                    @endif
                                    <td class="text-end">
                                        @if ($blog->status === 'pending')
                                            <span class="badge badge-warning text-warning">Pending</span>
                                        @elseif ($blog->status === 'active')
                                            <span class="badge badge-success text-success">Active</span>
                                        @elseif ($blog->status === 'rejected')
                                            <span class="badge badge-danger text-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('dashboard.blog.edit', $blog->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <form id="delete-blog-form-{{ $blog->id }}"
                                                action="{{ route('dashboard.blog.destroy', $blog->id) }}" method="post">
                                                @csrf @method('DELETE')
                                            </form>
                                            <a href="javascript:void(0);" onclick="confirmDelete({{ $blog->id }})"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">
                                        <h4>No blog(s) available</h4>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($pagination ?? '' !== false)
                    <div class="d-flex justify-content-center">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(blogId) {
            if (confirm('Are you sure you want to delete this blog?')) {
                document.getElementById('delete-blog-form-' + blogId).submit();
            }
        }

        window.addEventListener('load', function() {
            const appUrl = '{{ config('app.url') }}';
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('change', function() {
                    this.submit();
                });
            });
        });
    </script>
@endsection