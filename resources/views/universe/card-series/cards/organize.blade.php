<x-app-layout>
@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])
<style>

.photo-item{
    position:relative;
    cursor:grab;
}

.photo-img{
    width:50px;
    height:200px;
    object-fit:cover;
    border-radius:8px;
}

.photo-number{
    position:absolute;
    top:6px;
    left:6px;
    background:black;
    color:white;
    font-size:12px;
    padding:3px 6px;
    border-radius:4px;
}

</style>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Page Organizer') }}
    </h2>
</x-slot>
<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    
<form action="{{ route('issue_pages.StoreOrganizedPages', ['universe_id' => $_REQUEST['universe_id']  , 'book_id' => $_REQUEST['book_id'], $_REQUEST['issue_id']] ) }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="max-w-xl mx-auto p-4">

    <h2 class="text-xl font-bold mb-4">Reorder Photos</h2>

    <!-- Drag Sort Grid -->
    <div id="previewGrid" class="grid grid-cols-3 gap-3">
    @foreach($pages as $page)
        <!-- Placeholder images -->
        <div class="photo-item">
            <span class="photo-number">
                @if($page->issue_page_number)
                    <option id="{{$page->id}}" value="{{$page->issue_page_number}}" selected >{{$page->issue_page_number}}</option>
                @endif
            </span>
            @if($page->issue_page_url)            
                <a href="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" target="_blank"> <img src="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" alt="Image" class="aspect-[4/5] w-52 flex-none rounded-2xl object-cover"></a> 
            @else
                <img class="h-11 w-11 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            @endif
            <input type="hidden" name="images[{{ $page->id}}]" value="{{$page->issue_page_number}}">
        </div>

        <!-- <div class="photo-item">
            <span class="photo-number">2</span>
            <img src="https://picsum.photos/300/200?random=2" class="photo-img">
            <input type="hidden" name="images[]" value="2">
        </div>

        <div class="photo-item">
            <span class="photo-number">3</span>
            <img src="https://picsum.photos/300/200?random=3" class="photo-img">
            <input type="hidden" name="images[]" value="3">
        </div>

        <div class="photo-item">
            <span class="photo-number">4</span>
            <img src="https://picsum.photos/300/200?random=4" class="photo-img">
            <input type="hidden" name="images[]" value="4">
        </div>

        <div class="photo-item">
            <span class="photo-number">5</span>
            <img src="https://picsum.photos/300/200?random=5" class="photo-img">
            <input type="hidden" name="images[]" value="5">
        </div>

        <div class="photo-item">
            <span class="photo-number">6</span>
            <img src="https://picsum.photos/300/200?random=6" class="photo-img">
            <input type="hidden" name="images[]" value="6">
        </div> -->
    @endforeach
    </div>

    <button class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg">
        Submit Order
    </button>

</div>

</form>
</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>

const grid = document.getElementById('previewGrid');

new Sortable(grid,{
    animation:150,
    onEnd:updateNumbers
});

function updateNumbers(){

    const items = document.querySelectorAll(".photo-item");

    items.forEach((item,index)=>{

        item.querySelector(".photo-number").innerText = index+1;

        item.querySelector("input").value = index+1;

    });

}

</script>
</x-app-layout>