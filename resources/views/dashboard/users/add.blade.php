@extends('dashboard.layouts.app')

@section('contents')
    <div class="card mb-3">
        <div class="card-header border-bottom">
            <div class="row flex-between-end">
                <h4> Add User</h4>
               <div class="d-flex justify-content-end">
                <a href="{{route('dashboard.user.create')}}" class="btn btn-primary btn-sm">Add New</a>
               </div>
            </div>
        </div>
        <form action="{{ route('dashboard.user.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row justify-content-center mb-3">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <strong>User Information</strong>
                            <p>Required field are mark with <span class="required-field">*</span></p>

                        </div>

                        <div class="card-body card-block">
                           
                            <div class="form-group">
                                <label for="name" class="form-control-label">Name</label>
                                <input type="text" id="name" name="name" placeholder=""
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-control-label">Email <span
                                        class="required-field">*</span></label>
                                <input type="email" id="email" name="email" placeholder=""
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role" class="form-control-label">Role <span
                                        class="required-field">*</span></label>
                                <select id="role" name="role"
                                    class="form-control @error('role') is-invalid @enderror">
                                    <option value="" disabled selected>Select Role</option>
                                    @foreach ($userRoles as $role)
                                        <option value="{{ $role }}"
                                            {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Additional User Fields -->
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Additional User Fields</strong>
                        </div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="avatar" class="form-control-label">Avatar </span></label>
                                <input type="file" id="avatar" name="avatar" placeholder=""
                                    class="form-control @error('avatar') is-invalid @enderror"
                                    value="{{ old('avatar') }}">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <!-- Add more additional fields as needed -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-primary w-100 mx-auto">Create User</button>
                </div>
            </div>
        </form>
    </div>
   
@endsection
