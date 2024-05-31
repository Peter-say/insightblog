@extends('dashboard.layouts.app')

@section('contents')
    <div class="container-fluid mb-5">
        @include('notifications.flash_messages')
        <h4 class="fw-bold py-3 mb-1">Meta Title</h4><span><i>Write Your Website Title</i></span>

        <form action="{{route('dashboard.website-title.store')}}" method="post">
            @csrf
            <div class="form-group">
                <input class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" id="" />
                @error('meta_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div>
                <button class="btn btn-primary mt-2" type="submit">Save</button>
            </div>
        </form>

    </div>
@endsection
