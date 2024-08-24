<div>
    <form wire:submit.prevent="saveIssueCover">

         @if ($photo)
         
           Photo Preview:
            <img src="{{ $photo->temporaryUrl() }}">
         
        @endif

        <input type="file" wire:model="photo">

       
    
        @error('photo') <span class="error">{{ $message }}</span> @enderror
    
        @if(isset($logo))
            <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"  wire:click="saveIssueCover">Replace Photo</button>
        @else
            <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:click="saveIssueCover">Save Photo</button>
        @endif
    </form>
    <br>
</div>