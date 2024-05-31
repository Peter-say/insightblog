@extends('dashboard.layouts.app')

@section('contents')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile Information</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Update Password</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Delete User</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
