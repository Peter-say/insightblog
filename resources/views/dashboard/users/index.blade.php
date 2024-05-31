@extends('dashboard.layouts.app')

@section('contents')
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <h4> User List</h4>
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-primary btn-sm">Add New</a>
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
                                                <div class="d-flex justify-content-between">
                                                    <form id="delete-user-form-{{ $user->id }}"
                                                        action="{{ route('dashboard.user.destroy', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    {{-- <a href="{{ route('dashboard.user.edit', $user->id) }}"><i class="fa fa-edit"></i></a> --}}
                                                    <a href="javascript:void(0);"
                                                        onclick="confirmDelete({{ $user->id }})"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
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
