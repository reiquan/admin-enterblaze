<div>
    <form wire:submit.prevent="saveMultiple">
        @if ($photos)
           @foreach($photos as $photo)
           Photo Preview:
            <img src="{{ $photo->temporaryUrl() }}">
           @endforeach
        @endif
    
        <input type="file" wire:model="photos">
    
        @error('photos') <span class="error">{{ $message }}</span> @enderror
    
        <button wire:click="saveMultiple">Save Photo</button>
    </form>
</div>
