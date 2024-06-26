@extends('dashboard.layouts.app')

<style>
    #main-navigation {
        list-style: none;
        padding: 0;
    }

    #main-navigation .nav-item {
        margin-bottom: 10px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #main-navigation .nav-link {
        text-decoration: none;
        color: #007bff;
    }

    #main-navigation .link-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    #main-navigation .link-actions {
        display: flex;
        gap: 10px;
    }

    #main-navigation .edit-link, 
    #main-navigation .delete-link {
        text-decoration: none;
        color: #6c757d;
    }

    #main-navigation .edit-link:hover, 
    #main-navigation .delete-link:hover {
        color: #495057;
    }

    #main-navigation .dropdown-menu {
        list-style: none;
        padding-left: 20px;
        margin: 10px 0 0 0;
        border-left: 1px solid #ddd;
    }

    #main-navigation .dropdown-item {
        margin: 5px 0;
        padding: 5px;
        background: #f1f1f1;
        border-radius: 3px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

@section('contents')
<div class="container-fluid mb-5">
    <div class="card">
       <div class="card-body">
        <h2>Dynamic Navigation</h2>

        <!-- Form to add new links -->
        <form id="add-link-form" action="{{ route('dashboard.navigation-links.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="link-text" class="form-label">Link Text:</label>
                <input type="text" class="form-control" id="link-text" name="text" required>
            </div>
            <div class="mb-3">
                <label for="link-url" class="form-label">URL:</label>
                <input type="text" class="form-control" id="link-url" name="url" required>
            </div>
            <div class="mb-3">
                <label for="parent-id" class="form-label">Parent ID:</label>
                <select class="form-control" id="parent-id" name="parent_id">
                    <option value="">Select Parent</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->text }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Leave empty for top-level link. Select parent for sub-links.</small>
            </div>
            <button type="submit" class="btn btn-primary">Add Link</button>
        </form>

        <!-- Navigation Menu -->
        <ul id="main-navigation" class="navbar-nav">
            @foreach ($navigationLinks as $link)
                @if ($link->parent_id == null)
                    <li class="nav-item" id="link-{{ $link->id }}">
                        <div class="link-item">
                            <a class="nav-link" href="{{ $link->url }}">{{ $link->text }}</a>
                            <div class="link-actions">
                                <a href="#" class="edit-link" data-id="{{ $link->id }}">✏️</a>
                                <a href="#" class="delete-link" data-id="{{ $link->id }}">🗑️</a>
                            </div>
                        </div>
                        @if ($link->children->isNotEmpty())
                            <ul class="dropdown-menu">
                                @foreach ($link->children as $child)
                                    <li class="dropdown-item" id="link-{{ $child->id }}">
                                        <div class="link-item">
                                            <a href="{{ $child->url }}">{{ $child->text }}</a>
                                            <div class="link-actions">
                                                <a href="#" class="edit-link" data-id="{{ $child->id }}">✏️</a>
                                                <a href="#" class="delete-link" data-id="{{ $child->id }}">🗑️</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>

       </div>
    </div>
</div>

<!-- Modal for editing links -->
<div class="modal fade" id="editLinkModal" tabindex="-1" aria-labelledby="editLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLinkModalLabel">Edit Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-link-form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-link-text" class="form-label">Link Text:</label>
                        <input type="text" class="form-control" id="edit-link-text" name="text" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-link-url" class="form-label">URL:</label>
                        <input type="text" class="form-control" id="edit-link-url" name="url" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-parent-id" class="form-label">Parent:</label>
                        <select class="form-control" id="edit-parent-id" name="parent_id">
                            <option value="">Select Parent</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->text }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // AJAX request to add new link
        $('#add-link-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    var newLink = '<li class="nav-item" id="link-' + response.link.id + '">' +
                        '<div class="link-item">' +
                        '<a class="nav-link" href="' + response.link.url + '">' + response.link.text + '</a>' +
                        '<div class="link-actions">' +
                        '<a href="#" class="edit-link" data-id="' + response.link.id + '">✏️</a>' +
                        '<a href="#" class="delete-link" data-id="' + response.link.id + '">🗑️</a>' +
                        '</div>' +
                        '</div>' +
                        '</li>';
                    $('#main-navigation').append(newLink);
                    $('#add-link-form')[0].reset();
                }
            });
        });

        // Show edit modal for link
        $(document).on('click', '.edit-link', function(event) {
            event.preventDefault();
            var linkId = $(this).data('id');
            $.get('/dashboard/navigation-links/' + linkId, function(response) {
                $('#edit-link-text').val(response.link.text);
                $('#edit-link-url').val(response.link.url);
                $('#edit-parent-id').val(response.link.parent_id);
                $('#edit-link-form').attr('action', '/dashboard/navigation-links/' + linkId);
                $('#editLinkModal').modal('show');
            });
        });

        // AJAX request to update link
        $('#edit-link-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var linkId = $(this).attr('action').split('/').pop();
            $.ajax({
                url: '/dashboard/navigation-links/' + linkId,
                type: 'PUT',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    var updatedLink = '#link-' + response.link.id + ' .link-item';
                    $(updatedLink + ' .nav-link').attr('href', response.link.url).text(response.link.text);
                    $('#editLinkModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // AJAX request to delete link
        $(document).on('click', '.delete-link', function(event) {
            event.preventDefault();
            var linkId = $(this).data('id');
            if (confirm("Are you sure you want to delete this link?")) {
                $.ajax({
                    url: '/dashboard/navigation-links/' + linkId,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(response) {
                        $('#link-' + linkId).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection
