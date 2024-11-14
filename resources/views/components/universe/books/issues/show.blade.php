<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />
    @if(isset($pages[0]->issue->issue_number))
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
        <strong>{{ $pages[0]->issue->issue_number }}</strong> {{ $pages[0]->issue->issue_title }}
        </h1>

        <p class="mt-6 text-gray-500 leading-relaxed">
        {{ $pages[0]->issue->issue_description }}
        </p>
    @else
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
        <strong></strong> 
        </h1>

        <p class="mt-6 text-gray-500 leading-relaxed">
        
        </p>
    @endif
</div>
<div class="relative block w-full h-full rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    <div class="mx-auto h-48 w-48 text-gray-400">
        @if($book->book_image_path)
            
            <img src="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" alt="Image" class="lg:h-full lg:w-full">

        @else
            <img class="rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
        @endif
    </div>
</div>
<br>
<form action="{{ route('issue_pages.addPage', ['universe_id' => $_REQUEST['u_id'] ?? $book->universe->id , 'book_id' => $_REQUEST['b_id'] ?? $book->id, 'issue_id' => $issue->id] ) }}" method="GET" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    <input type="hidden" name="universe_id" value="{{$_REQUEST['u_id'] ?? $book->universe->id }}">
    <input type="hidden" name="book_id" value="{{ $_REQUEST['b_id'] ?? $book->universe->id }}">  
    
    <span class="mt-2 block text-sm font-semibold text-gray-900">
        <button type="submit">
          <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
          </svg>
    
          Add New Page

        </button>
    </span>

</form>

<br>

    @foreach ($pages as $page)
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"></th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Page #</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>

                        
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr>
                        <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($page->issue_page_url)
                                
                                  <a href="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" target="_blank"> <img src="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" alt="Image" class="aspect-[4/5] w-52 flex-none rounded-2xl object-cover"></a> 
                
                                @else
                                    <img class="h-11 w-11 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                @endif
                            </div>
                            <div class="ml-4">
                            <div class="font-medium text-gray-900">{{ $page->id }}</div>
                            <div class="mt-1 text-gray-500">{{ $issue->title }}</div>
                            </div>
                        </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                        <span>                                                        <!--
                            This example requires some changes to your config:
                            
                            ```
                            // tailwind.config.js
                            module.exports = {
                                // ...
                                plugins: [
                                // ...
                                require('@tailwindcss/forms'),
                                ],
                            }
                            ```
                            -->
                            <div>
                
                                <select id="issue_page_number{{$page->id}}"  onchange="swapPageNumber('{{ $page->id }}', 'Unlock')" name="issue_page_number" class="mt-2 block rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                   @foreach($issue->pages as $count)
                                        @if($count->issue_page_number == $page->issue_page_number)
                                            <option id="{{$count->id}}" value="{{$count->issue_page_number}}" selected >{{$count->issue_page_number}}</option>
                                        @else
                                            <option id="{{$count->id}}" value="{{$count->issue_page_number}}">{{$count->issue_page_number}}</option>
                                        @endif
                                   @endforeach
                                </select>
                            </div>
                        </span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                            @if($page->issue_page_is_locked)
                            <span id="toggleLock{{ $page->id }}" onclick="isVisible('{{ $page->id }}', 'Unlock')"class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20"><button>Locked</button></span>
                            @else
                            <span id="toggleLock{{ $page->id }}" onclick="isVisible('{{ $page->id }}', 'Lock')"class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"><button>Unlocked</button></span>
                            @endif
                        </td>
                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                            <button onclick="confirmDelete('{{ $page->id }}')" class="text-red-600 hover:text-red-900">Delete<span class="sr-only">, Lindsay Walton</span></button>
                        </td>
                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <form action="{{ route('issue_pages.editPage', ['universe_id' => $_REQUEST['u_id'] ?? $book->universe->id, 'book_id' => $_REQUEST['b_id'] ?? $book->id, 'issue_id' => $issue->id, 'page_id' => $page->id]) }}">
                            <input type="hidden" id ="u_id" name="u_id" value="{{ $_REQUEST['u_id'] ?? $book->universe->id }}">
                            <input type="hidden" id ="b_id" name="b_id" value="{{ $_REQUEST['b_id'] ?? $book->id }}">
                            <input type="hidden" id ="i_id" name="issue_id" value="{{ $issue->id }}">
                            <input type="hidden" id ="issue_page_id" name="issue_page_id" value="{{ $page->id }}">
                            <button class="text-green-600 hover:text-green-900">Replace<span class="sr-only">, Lindsay Walton</span></button>
                        </form>
                        </td>
                    </tr>

                    <!-- More people... -->
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    @endforeach




