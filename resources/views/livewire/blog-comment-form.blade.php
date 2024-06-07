<div>
    <h3 class="mb-4">Leave a Reply</h3>
    <form wire:submit.prevent="submit">
        <div class="row">
            <div class="form-group col-md-12">
                <textarea class="form-control shadow-none @error('body') is-invalid @enderror" wire:model="body" rows="7" required></textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if (!Auth::check())
                <div class="form-group col-md-4">
                    <input class="form-control shadow-none @error('commenter_name') is-invalid @enderror" type="text" wire:model="commenter_name" placeholder="Name" required>
                    @error('commenter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <input class="form-control shadow-none @error('commenter_email') is-invalid @enderror" type="email" wire:model="commenter_email" placeholder="Email" required>
                    @error('commenter_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <div class="form-group col-md-4">
                <input class="form-control shadow-none" type="url" wire:model="commenter_website" placeholder="Website">
                <p class="font-weight-bold valid-feedback">OK! You can skip this field.</p>
            </div>
        </div>
        <input type="hidden" wire:model="parent_id">
        <button class="btn btn-primary" type="submit">Comment Now</button>
    </form>
    {{-- @if (session()->has('message'))
        <div class="alert alert-success mt-4">
            {{ session('message') }}
        </div>
    @endif --}}
</div>
