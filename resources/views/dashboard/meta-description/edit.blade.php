@extends('dashboard.layouts.app')

@section('contents')
    <div class="container-fluid mb-5">
        <h4 class="fw-bold py-3 mb-1">Meta Description</h4><span><i>A recommended meta description should not be more than
                150 words</i></span>
        <form
            action="{{route('dashboard.website-meta-description.update', $website_meta_description->id)}}" method="post">
            @csrf @method(isset($website_meta_description) ? 'PUT' : 'POST')
            <div class="form-group">
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="" cols="30"
                    rows="4">{{$website_meta_description->description}}</textarea>
                @error('description')
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
