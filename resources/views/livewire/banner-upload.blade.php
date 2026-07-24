<div>
    <form wire:submit.prevent="save">

         @if ($photo)
         
           Photo Preview:
            <img src="{{ $photo->temporaryUrl() }}">
         
        @endif

        <input
            type="file"
            wire:model="photo"
            accept="image/*"
        >
    
    
        @if(isset($logo))

            @error('photo')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button class="mt-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="button" wire:click="save">
                Upload Banner
            </button>
        @else
            <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:click="save">Save Photo</button>
        @endif
    </form>
    <br>
</div>
