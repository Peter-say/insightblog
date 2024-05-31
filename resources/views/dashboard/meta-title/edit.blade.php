@extends('dashboard.layouts.app')

@section('contents')
    <div class="container-fluid mb-3">
       
        <h4 class="fw-bold py-3 mb-1">Meta Title</h4><span><i>Write Your Website Title</i></span>

        <form action="{{ route('dashboard.website-title.update', $website_title->id) }}" method="post">
            @csrf @method('PUT')
            <div class="form-group">
                <input class="form-control @error('meta_title') is-invalid  @enderror" value="{{ $website_title->meta_title ?? old('meta_title')}}"
                    name="meta_title" id="" />
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
