@extends('dashboard.layouts.app')

@section('contents')
    <div class="container-fluid mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Manage Comments</div>
                    <div class="card-body">
                        @foreach ($comments as $comment)
                            <div class="media mb-4">
                                <img class="mr-3 rounded-circle" src="https://via.placeholder.com/50" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ $comment->commenter_name }}</h5>
                                    <p>{{ $comment->body }}</p>
                                    <div>
                                        <span><b>Commented on blog:</b></span> 
                                        <span>
                                            <a href="{{ route('post.details', $comment->post->slug) }}?highlight_comment_id={{ $comment->id }}" target="_blank" rel="noopener noreferrer">
                                                {{ $comment->post->title }}
                                            </a>
                                        </span>
                                    </div>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    <div class="mt-2">
                                        @if ($comment->status == 'pending')
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approveModal{{ $comment->id }}">Approve</button>
                                        @endif
                                        @if(Auth::user() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Moderator' || Auth::user() === $comment->post->user_id))
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $comment->id }}">Reject</button>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $comment->id }}">Edit</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{ $comment->id }}">Delete</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger" disabled>Reject</button>
                                        <button type="button" class="btn btn-sm btn-primary" disabled>Edit</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" disabled>Delete</button>
                                    @endif
                                    
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $comment->id }}">Delete Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this comment?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="approveModalLabel{{ $comment->id }}">Approve Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.comments.approve', $comment->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Are you sure you want to approve this comment?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel{{ $comment->id }}">Reject Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.comments.reject', $comment->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Are you sure you want to reject this comment?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $comment->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $comment->id }}">Edit Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.comments.update', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="editedBody{{ $comment->id }}">Comment:</label>
                                                    <textarea class="form-control" id="editedBody{{ $comment->id }}" name="body" rows="3">{{ $comment->body }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
