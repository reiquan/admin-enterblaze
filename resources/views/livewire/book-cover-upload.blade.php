<div>
    <form wire:submit.prevent="saveBookCover">

    @if ($photo)
    <img src="{{ $photo->temporaryUrl() }}" class="aspect-[4/5] w-full rounded-3xl object-cover">
@elseif ($current)
    <img src="{{ $current }}" class="aspect-[4/5] w-full rounded-3xl object-cover">
@else
    <div class="aspect-[4/5] w-full rounded-3xl border-2 border-dashed border-gray-300 bg-gray-50"></div>
@endif

        <input type="file" wire:model="photo">

       
    
        @error('photo') <span class="error">{{ $message }}</span> @enderror
    
        @if(isset($logo))
            <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"  wire:click="saveBookCover">Replace Photo</button>
        @else
            <button class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:click="saveBookCover">Save Photo</button>
        @endif
    </form>
    <br>
</div>