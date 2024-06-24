@extends('dashboard.layouts.app')
<style>
    .inline-actions {
    display: flex;
    align-items: center;
}

.inline-actions form,
.inline-actions a {
    margin-right: 10px; /* Adjust as needed */
}

.inline-actions .form-check {
    margin-bottom: 0; /* Override Bootstrap's mb-2 if needed */
}
</style>
@section('contents')
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <h4> User List</h4>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary btn-sm">Add New</a>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">
                <div class="tab-pane preview-tab-pane active" role="tabpanel">
                    <div class="table-responsive scrollbar">
                        <table id="users-table" class="table table-hover table-striped overflow-hidden">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Avatar</th>
                                    <th class="text-nowrap">Full Name</th>
                                    <th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Role</th>
                                    <th class="text-nowrap">Blog Count</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count())
                                    @foreach ($users as $user)
                                        <tr class="align-middle">
                                            <td class="text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        @if (!empty($user->avatar))
                                                            <img class="rounded-circle"
                                                                src="{{ asset('storage/user/images/' . $user->avatar) }}"
                                                                alt="" />
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ asset('dashboard/assets/img/team/avatar.png') }}"
                                                                alt="" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">{{ $user->name }}</td>
                                            <td class="text-nowrap">{{ $user->email }}</td>


                                            <td class="text-nowrap">
                                                <form action="{{ route('dashboard.user.role', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" class="form-select" onchange="this.form.submit()"
                                                        {{ $user->role == 'Admin' ? 'disabled' : '' }}>
                                                        <option value="Admin"
                                                            {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="Moderator"
                                                            {{ $user->role == 'Moderator' ? 'selected' : '' }}>Moderator
                                                        </option>
                                                        <option value="Author"
                                                            {{ $user->role == 'Author' ? 'selected' : '' }}>Author</option>
                                                        <option value="User"
                                                            {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                                                    </select>
                                                </form>
                                            </td>


                                            <td class="text-nowrap">{{ $user->blogs->count() }} </td>
                                            <td>
                                                @if ($user->role !== 'Admin')
                                                    <div class="inline-actions">
                                                        <!-- Verify Email Checkbox -->
                                                        <form action="{{ route('dashboard.user.verify-email', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" name="email_verified" id="email_verified_{{ $user->id }}" {{ $user->email_verified_at ? 'checked' : '' }} onchange="this.form.submit()">
                                                                <label class="form-check-label" for="email_verified_{{ $user->id }}">Verify Email</label>
                                                            </div>
                                                        </form>
                                                        <!-- Resend Login Details Button -->
                                                        <form action="{{ route('dashboard.user.send-login-details', ['userId' => $user->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-dark btn-sm">Resend Login Details</button>
                                                        </form>
                                                        <!-- Delete User Icon -->
                                                        <form id="delete-user-form-{{ $user->id }}" action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:void(0);" onclick="confirmDelete({{ $user->id }})" class="text-danger">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <h4>No user(s) available</h4>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($pagination ?? '' !== false)
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                document.getElementById('delete-user-form-' + userId).submit();
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
