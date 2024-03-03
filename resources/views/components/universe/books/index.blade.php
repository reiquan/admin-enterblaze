<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

<br>
<form action="{{ route('books.create', ['universe_id' => $universe->id]) }}" method="GET" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    <input type="hidden" name="universe_id" value="{{ $universe->id }}">
    
    <span class="mt-2 block text-sm font-semibold text-gray-900">
        <button type="submit">
          <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
          </svg>
    
          Add New Book

        </button>
    </span>

</form>

<br>

    @foreach ($books as $book)
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">{{ $book->book_title }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status: <p class="mt-1 text-gray-500">{{ $book->is_active ? 'Published' : 'Unpublished' }}</p> </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Creator</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Audience</th>

                        
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr>
                        <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div class="h-11 w-11 flex-shrink-0">
                                    @if($book->book_image_path)
                                    
                                        <img src="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" alt="Image" class="rounded-full h-48 w-48 object-cover object-center lg:h-full lg:w-full">
                    
                                    @else
                                        <img class="h-11 w-11 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    @endif
                                </div>
                                <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $book->id }}</div>
                                <div class="mt-1 text-gray-500">{{ $book->book_subtitle }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                            @if($book->is_active)
                                <button id="unpublish" onclick="publishAction('unpublish', '{{ $book->book_slug_name }}', '{{ $book->id }}')" class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-yellow-600 py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">

                                        <span>Unpublish</span>
                                        <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                </button>
                            @else
                                <button id="publish" onclick="publishAction('publish', '{{ $book->book_slug_name }}', '{{ $book->id }}')" class="text-white rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-green-700 py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                                    <span>Publish</span>
                                    <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                                </button>
                            @endif
                        </td>
                        <td scope="col" class="mt-1 text-gray-500">{{ $book->book_creator }}</td>
                        <td scope="col" class="mt-1 text-gray-500">{{ $book->book_audience }}</td>
                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                            <button onclick="confirmDelete('{{ $book->id }}')" class="text-red-600 hover:text-red-900">Delete<span class="sr-only">, Lindsay Walton</span></button>
                        </td>

                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                            <form action="{{ route('books.edit', ['universe_id' => $book->universe->id, 'book_id' => $book->id]) }}">
                                <input type="hidden" id ="u_id{{ $book->id }}" name="u_id" value="{{ $book->universe->id }}">
                                <input type="hidden" id ="b_id{{ $book->id }}" name="b_id" value="{{ $book->id }}">
                                <button class="text-green-600 hover:text-green-900">Edit<span class="sr-only">, Lindsay Walton</span></button>
                            </form>
                        </td>
                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                            <form action="{{ route('books.show', ['universe_id' => $book->universe->id, 'book_id' => $book->id]) }}">
                                <input type="hidden" id ="u_id{{ $book->id }}" name="u_id" value="{{ $book->universe->id }}">
                                <input type="hidden" id ="b_id{{ $book->id }}" name="b_id" value="{{ $book->id }}">
                                <button class="text-gray-400 hover:text-green-900"><strong>View</strong><span class="sr-only">, Lindsay Walton</span></button>
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




