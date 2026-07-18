<div class="min-h-screen bg-gray-50 px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-8">

        {{-- Page Hero --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="relative isolate p-8 sm:p-10">
                <div class="absolute inset-x-0 top-0 h-1 bg-indigo-600"></div>

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Universe Library</p>
                                <h1 class="mt-1 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                    Book Manager
                                </h1>
                            </div>
                        </div>

                        <p class="mt-5 max-w-2xl text-sm leading-6 text-gray-600">
                            Manage the books, manga volumes, one-shots, and story releases connected to this universe.
                        </p>
                    </div>

                    <form action="{{ route('books.create', ['universe_id' => $universe->id]) }}" method="GET">
                        <input type="hidden" name="universe_id" value="{{ $universe->id }}">

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Add New Book
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">Total Books</p>
                <p class="mt-3 text-3xl font-black text-gray-950">{{ $books->count() }}</p>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">Published</p>
                <p class="mt-3 text-3xl font-black text-gray-950">{{ $books->where('is_active', true)->count() }}</p>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">Drafts</p>
                <p class="mt-3 text-3xl font-black text-gray-950">{{ $books->where('is_active', false)->count() }}</p>
            </div>
        </div>

        {{-- Create CTA --}}
        <form action="{{ route('books.create', ['universe_id' => $universe->id]) }}" method="GET"
              class="group block rounded-3xl border-2 border-dashed border-gray-300 bg-white p-8 text-center shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50/30">
            <input type="hidden" name="universe_id" value="{{ $universe->id }}">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 transition group-hover:bg-indigo-100 group-hover:text-indigo-600">
                <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v12m6-6H34" />
                </svg>
            </div>

            <button type="submit" class="mt-4 text-sm font-black text-gray-950">
                Create a new book for this universe
            </button>
            <p class="mt-2 text-sm text-gray-500">
                Add cover art, audience details, creator info, and publication controls.
            </p>
        </form>

        {{-- Books Grid --}}
        @if(!empty($books) && $books->count())
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($books as $book)
                    <article class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                                        Book #{{ $book->id }}
                                    </p>
                                    <h2 class="mt-2 line-clamp-2 text-xl font-black tracking-tight text-gray-950">
                                        {{ $book->book_title }}
                                    </h2>
                                </div>

                                @if($book->is_active)
                                    <span class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex shrink-0 items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700 ring-1 ring-inset ring-orange-600/20">
                                        Draft
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5 overflow-hidden rounded-3xl bg-gray-100">
                                @if($book->book_image_path)
                                    <a href="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" target="_blank">
                                        <img src="{{ Storage::disk('s3-public')->url($book->book_image_path) }}"
                                             alt="{{ $book->book_title }} cover"
                                             class="aspect-[4/5] w-full object-cover transition duration-300 hover:scale-105">
                                    </a>
                                @else
                                    <div class="flex aspect-[4/5] w-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                                            </svg>
                                            <p class="mt-3 text-sm font-bold text-gray-500">No cover uploaded</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <p class="mt-5 line-clamp-2 text-sm leading-6 text-gray-600">
                                {{ $book->book_subtitle ?: 'No subtitle added yet.' }}
                            </p>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-gray-50 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Creator</p>
                                    <p class="mt-2 truncate text-sm font-bold text-gray-900">{{ $book->book_creator ?: 'Not set' }}</p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Audience</p>
                                    <p class="mt-2 truncate text-sm font-bold text-gray-900">{{ $book->book_audience ?: 'Not set' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 bg-gray-50/70 p-5">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex gap-2">
                                    @if($book->is_active)
                                        <button id="unpublish{{ $book->id }}"
                                                onclick="publishAction('unpublish', '{{ $book->book_slug_name }}', '{{ $book->id }}')"
                                                class="rounded-2xl bg-yellow-500 px-4 py-2 text-xs font-black text-gray-950 shadow-sm transition hover:bg-yellow-400">
                                            Unpublish
                                        </button>
                                    @else
                                        <button id="publish{{ $book->id }}"
                                                onclick="publishAction('publish', '{{ $book->book_slug_name }}', '{{ $book->id }}')"
                                                class="rounded-2xl bg-green-600 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-green-700">
                                            Publish
                                        </button>
                                    @endif

                                    <button onclick="confirmDelete('{{ $book->id }}')"
                                            class="rounded-2xl bg-red-50 px-4 py-2 text-xs font-black text-red-700 ring-1 ring-inset ring-red-600/20 transition hover:bg-red-100">
                                        Delete
                                    </button>
                                </div>

                                <div class="flex gap-2">
                                    <form action="{{ route('books.edit', ['universe_id' => $book->universe->id, 'book_id' => $book->id]) }}">
                                        <input type="hidden" id="u_id{{ $book->id }}" name="u_id" value="{{ $book->universe->id }}">
                                        <input type="hidden" id="b_id{{ $book->id }}" name="b_id" value="{{ $book->id }}">
                                        <button class="rounded-2xl bg-white px-4 py-2 text-xs font-black text-indigo-700 ring-1 ring-inset ring-indigo-600/20 transition hover:bg-indigo-50">
                                            Edit 
                                        </button>
                                    </form>

                                    <form action="{{ route('books.show', ['universe_id' => $book->universe->id, 'book_id' => $book->id]) }}">
                                        <input type="hidden" id="show_u_id{{ $book->id }}" name="u_id" value="{{ $book->universe->id }}">
                                        <input type="hidden" id="show_b_id{{ $book->id }}" name="b_id" value="{{ $book->id }}">
                                        <button class="rounded-2xl bg-gray-950 px-4 py-2 text-xs font-black text-white transition hover:bg-gray-800">
                                            Chapters
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-indigo-50 text-indigo-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <h2 class="mt-5 text-2xl font-black tracking-tight text-gray-950">
                    No books created yet
                </h2>

                <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-gray-500">
                    Start building this universe by adding its first book, manga volume, or story release.
                </p>

                <form action="{{ route('books.create', ['universe_id' => $universe->id]) }}" method="GET" class="mt-6">
                    <input type="hidden" name="universe_id" value="{{ $universe->id }}">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700">
                        Create First Book
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
