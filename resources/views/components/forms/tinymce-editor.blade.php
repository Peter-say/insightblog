<textarea name="body"  id="myeditorinstance"
    class="form-control @error('body') is-invalid @enderror" aria cols="30" rows="10">{{ old('body', $blog->body) }}</textarea>


