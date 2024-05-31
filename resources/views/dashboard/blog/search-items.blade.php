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
                                    src="{{ asset('storage/blog/images/' . $blog->cover_image) }}" alt="" />
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
                    <a href="{{ route('dashboard.blog.edit', $blog->id) }}"><i class="fa fa-edit"></i></a>
                    <form id="delete-blog-form-{{ $blog->id }}"
                        action="{{ route('dashboard.blog.destroy', $blog->id) }}" method="post">
                        @csrf @method('DELETE')
                    </form>
                    <a href="javascript:void(0);" onclick="confirmDelete({{ $blog->id }})"><i
                            class="fa fa-trash"></i></a>
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
