@extends('dashboard.layouts.app')

@section('contents')
    <div class="container-fluid mb-5">
        <h4 class="fw-bold py-3 mb-1">Settings</h4>
        {{-- @if (Auth::user()->role == 'Admin')
            <div class="card mt-2">
                <div class="card-header">
                    <h5>Permissions/Roles</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span> View, Add or remove role from users</span>
                        <span><a href="{{ route('dashboard.role') }}" class="btn btn-primary">Proceed</a></span>
                    </div>
                </div>
            </div>
        @endif --}}

        @if (Auth::user()->role == 'Admin' || (Auth::user()->role == 'Moderator' || Auth::user()->role == 'Author'))

            <div class="card mt-2 mb-2">
                <div class="card-header">
                    <h5>Website Title</h5>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        @if (empty($website_title->meta_title))
                            Change or update website title
                            @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Moderator')
                                <span><a href="{{ route('dashboard.website-title.create') }}"
                                        class="btn btn-primary">Proceed</a></span>
                            @endif
                        @else
                            <div class="d-flex justify-content-between col-lg-8 col-xl-8 col-md-12 col-sm-12">
                                <h2>{{ $website_title->meta_title ?? config('app.name') }}</h2>
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Moderator')
                                    <span><a href="{{ route('dashboard.website-title.edit', $website_title->id) }}"
                                            class="btn btn-primary ">Edit</a></span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    <h5>Website Meta Description</h5>
                </div>
                <div class="card-body">
                    @if (empty($website_meta_description->description))
                        <div class="d-flex justify-content-between">
                            Add or update website description
                            @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Moderator')
                                <span><a href="{{ route('dashboard.website-meta-description.create') }}"
                                        class="btn btn-primary">Proceed</a></span>
                            @endif
                        @else
                            <div class="row">
                                <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12">
                                    {{ $website_meta_description->description }}
                                </div>
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Moderator')
                                    <div class="d-flex justify-content-around col-lg-4 col-xl-4 col-md-12 col-sm-12 mt-2">
                                        <span><a href="{{ route('dashboard.website-meta-description.edit', $website_meta_description->id) }}"
                                                class="btn btn-primary ">Edit</a></span>
                                @endif

                                @if (Auth::user()->role == 'Admin')
                                    <span>
                                        <form
                                            action="{{ route('dashboard.website-meta-description.destroy', $website_meta_description->id) }}"
                                            onsubmit="return confirm('This action can not be revoke. Are you sure you want to proceed?')"
                                            method="post">
                                            @csrf @method('DELETE')
                                            <button onclick="$(this).parent().trigger('submit')"
                                                class="btn btn-danger">Remove</button>
                                        </form>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    </div>
@endsection
