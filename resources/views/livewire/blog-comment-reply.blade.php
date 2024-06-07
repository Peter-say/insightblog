<div>
    
    @if ($showReplyForm)
    <form wire:submit.prevent="showReplyForm">
        <div class="row">
            <div class="form-group col-md-12">
                <textarea wire:model="body" class="form-control shadow-none @error('body') is-invalid @enderror" rows="7"
                    required></textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if (!Auth::check())
                <div class="form-group col-md-4">
                    <input wire:model="commenterName"
                        class="form-control shadow-none @error('commenter_name') is-invalid @enderror"
                        type="text" placeholder="Name" required>
                    @error('commenter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <input wire:model="commenterEmail"
                        class="form-control shadow-none @error('commenter_email') is-invalid @enderror"
                        type="email" placeholder="Email" required>
                    @error('commenter_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <div class="form-group col-md-4">
                <input wire:model="commenterWebsite" class="form-control shadow-none" type="url"
                    placeholder="Website">
                <p class="font-weight-bold valid-feedback">OK! You can skip this field.</p>
            </div>
        </div>
        <input type="hidden" wire:model="parentId">
        <button class="btn btn-primary" type="submit">Comment Now</button>
    </form>
    @endif
</div>
