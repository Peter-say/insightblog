@if (session()->has('success_message'))
    <div id="popup-message" class="popup-message success">
        <div class="d-flex justify-content-around">
            <p class="text-white">{{ session('success_message') }}</p>
            {{-- <span id="cancel-popup" wire:click="closePopup">X</span> --}}
        </div>
    </div>
@endif

@if (session()->has('error_message'))
    <div class="popup-message error " id="popup-message">
        <div class="d-flex justify-content-around">
            <p class="text-white">{!! session('error_message')!!}</p>
            {{-- <span id="cancel-popup" wire:click="closePopup">X</span> --}}
        </div>
    </div>
@endif
