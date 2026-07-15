<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-8">

        {{-- Page Hero --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="p-6 sm:p-8 lg:col-span-8">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                Book Library
                            </p>

                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                {{ $book->book_title ?? 'Book Details' }}
                            </h1>

                            @if(!empty($book->book_subtitle))
                                <p class="mt-3 max-w-2xl text-base font-semibold text-gray-600">
                                    {{ $book->book_subtitle }}
                                </p>
                            @endif

                            @if(!empty($book->book_description))
                                <p class="mt-4 max-w-3xl text-sm leading-6 text-gray-500">
                                    {{ $book->book_description }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if(!empty($book->is_active))
                                <span class="inline-flex items-center rounded-full bg-green-50 px-4 py-2 text-xs font-black uppercase tracking-widest text-green-700 ring-1 ring-green-200">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-orange-50 px-4 py-2 text-xs font-black uppercase tracking-widest text-orange-700 ring-1 ring-orange-200">
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Chapters</p>
                            <p class="mt-2 text-3xl font-black text-gray-950">{{ isset($issues) ? $issues->count() : 0 }}</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Unlocked</p>
                            <p class="mt-2 text-3xl font-black text-gray-950">
                                {{ isset($issues) ? $issues->where('issue_is_locked', false)->count() : 0 }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Locked</p>
                            <p class="mt-2 text-3xl font-black text-gray-950">
                                {{ isset($issues) ? $issues->where('issue_is_locked', true)->count() : 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 bg-gray-100 p-6 sm:p-8 lg:col-span-4 lg:border-l lg:border-t-0">
                    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                        @if($book->book_image_path)
                            <a href="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" target="_blank">
                                <img
                                    src="{{ Storage::disk('s3-public')->url($book->book_image_path) }}"
                                    alt="{{ $book->book_title ?? 'Book cover' }}"
                                    class="aspect-[4/5] w-full object-cover"
                                >
                            </a>
                        @else
                            <div class="flex aspect-[4/5] w-full items-center justify-center bg-gray-50 p-8 text-center">
                                <div>
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-sm font-black text-gray-900">No cover uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Chapter CTA --}}
        <div class="rounded-3xl border border-dashed border-indigo-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v12m6-6H34" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Chapter Builder</p>
                        <h2 class="mt-2 text-2xl font-black text-gray-950">Add a new chapter</h2>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                            Create a new chapter, upload cover art, set lock status, and prepare it for readers.
                        </p>
                    </div>
                </div>

                <form action="{{ route('issues.create', ['universe_id' => $book->universe->id, 'book_id' => $book->id] ) }}" method="GET">
                    <input type="hidden" name="universe_id" value="{{ $book->universe->id }}">
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto"
                    >
                        + Add New Chapter
                    </button>
                </form>
            </div>
        </div>

        {{-- Chapters --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Issues</p>
                    <h2 class="mt-3 text-2xl font-black text-gray-950">Chapter Library</h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Manage chapter visibility, edits, previews, and reader access.
                    </p>
                </div>
            </div>

            @if(isset($issues) && $issues->count())
                <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach ($issues as $issue)
                        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="grid grid-cols-1 sm:grid-cols-12">
                                <div class="bg-gray-100 sm:col-span-4">
                                    @if($issue->issue_image_cover)
                                        <a href="{{ Storage::disk('s3-public')->url($issue->issue_image_cover) }}" target="_blank">
                                            <img
                                                src="{{ Storage::disk('s3-public')->url($issue->issue_image_cover) }}"
                                                alt="{{ $issue->issue_title ?? 'Chapter cover' }}"
                                                class="aspect-[4/5] w-full object-cover"
                                            >
                                        </a>
                                    @else
                                        <div class="flex aspect-[4/5] w-full items-center justify-center p-6 text-center">
                                            <div>
                                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5A1.5 1.5 0 0021.75 18V6A1.5 1.5 0 0020.25 4.5H3.75A1.5 1.5 0 002.25 6v12A1.5 1.5 0 003.75 19.5z" />
                                                    </svg>
                                                </div>
                                                <p class="mt-3 text-xs font-black text-gray-500">No Cover</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col justify-between p-5 sm:col-span-8">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($issue->issue_is_locked)
                                                <span class="rounded-full bg-yellow-50 px-3 py-1 text-xs font-black text-yellow-700 ring-1 ring-yellow-200">Locked</span>
                                            @else
                                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700 ring-1 ring-green-200">Unlocked</span>
                                            @endif

                                            @if($issue->issue_is_adult)
                                                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-black text-red-700 ring-1 ring-red-200">Adult</span>
                                            @endif

                                            <span class="rounded-full bg-gray-50 px-3 py-1 text-xs font-black text-gray-500 ring-1 ring-gray-200">
                                                #{{ $issue->id }}
                                            </span>
                                        </div>

                                        <h3 class="mt-4 text-xl font-black text-gray-950">
                                            {{ $issue->issue_title }}
                                        </h3>

                                        @if(!empty($issue->issue_description))
                                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                                {{ $issue->issue_description }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-6 flex flex-wrap gap-2">
                                        @if($issue->issue_is_locked)
                                            <button
                                                id="unpublish{{ $issue->id }}"
                                                onclick="isVisible('unpublish', '{{ $issue->issue_slug_name }}', '{{ $issue->id }}')"
                                                class="inline-flex items-center justify-center rounded-2xl bg-yellow-500 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-yellow-600"
                                                type="button"
                                            >
                                                Unlock
                                            </button>
                                        @else
                                            <button
                                                id="publish{{ $issue->id }}"
                                                onclick="isVisible('publish', '{{ $issue->issue_slug_name }}', '{{ $issue->id }}')"
                                                class="inline-flex items-center justify-center rounded-2xl bg-gray-900 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-gray-800"
                                                type="button"
                                            >
                                                Lock
                                            </button>
                                        @endif

                                        <form action="{{ route('issues.show', ['universe_id' => $book->universe->id, 'book_id' => $book->id, 'issue_id' => $issue->id]) }}" method="GET">
                                            <input type="hidden" id="u_id{{ $book->id }}" name="u_id" value="{{ $book->universe->id }}">
                                            <input type="hidden" id="b_id{{ $book->id }}" name="b_id" value="{{ $book->id }}">

                                            <button class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-xs font-black text-gray-700 shadow-sm transition hover:bg-gray-50" type="submit">
                                                View
                                            </button>
                                        </form>

                                        <form action="{{ route('issues.edit', ['universe_id' => $book->universe->id, 'book_id' => $book->id, 'issue_id' => $issue->id]) }}" method="GET">
                                            <input type="hidden" id="u_id{{ $issue->id }}" name="u_id" value="{{ $book->universe->id }}">
                                            <input type="hidden" id="b_id{{ $issue->id }}" name="b_id" value="{{ $book->id }}">
                                            <input type="hidden" id="i_id{{ $issue->id }}" name="i_id" value="{{ $issue->id }}">

                                            <button class="inline-flex items-center justify-center rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-2 text-xs font-black text-indigo-700 shadow-sm transition hover:bg-indigo-100" type="submit">
                                                Edit
                                            </button>
                                        </form>

                                        <button
                                            onclick="confirmDelete('{{ $issue->id }}')"
                                            class="inline-flex items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-4 py-2 text-xs font-black text-red-700 shadow-sm transition hover:bg-red-100"
                                            type="button"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-8 rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v12m6-6H34" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-xl font-black text-gray-950">No chapters yet</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Start building this book by adding your first chapter.
                    </p>

                    <form class="mt-6" action="{{ route('issues.create', ['universe_id' => $book->universe->id, 'book_id' => $book->id] ) }}" method="GET">
                        <input type="hidden" name="universe_id" value="{{ $book->universe->id }}">
                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700"
                        >
                            + Add First Chapter
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
