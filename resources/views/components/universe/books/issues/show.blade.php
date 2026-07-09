<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    @php
        $book->book_universe_id = $_REQUEST['u_id'] ?? $book->universe->id;
        $book->id = $_REQUEST['b_id'] ?? $book->id;
        $chapter = $pages[0]->issue ?? $issue ?? null;
        $pageCount = isset($pages) ? count($pages) : 0;
        $lockedCount = isset($pages) ? collect($pages)->where('issue_page_is_locked', true)->count() : 0;
        $unlockedCount = $pageCount - $lockedCount;
    @endphp

    <div class="mx-auto max-w-7xl space-y-8">
        {{-- Hero --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="p-6 sm:p-8 lg:col-span-8">
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Chapter Pages</p>

                    <h1 class="mt-4 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                        @if(isset($chapter->issue_number))
                            Chapter {{ $chapter->issue_number }}: {{ $chapter->issue_title }}
                        @else
                            Manage Chapter Pages
                        @endif
                    </h1>

                    <p class="mt-4 max-w-3xl text-sm leading-6 text-gray-600">
                        {{ $chapter->issue_description ?? 'Upload, replace, organize, and lock pages for this chapter before publishing it to your readers.' }}
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <form action="{{ route('issue_pages.addPage', ['universe_id' => $book->book_universe_id, 'book_id' => $book->id, 'issue_id' => $issue->id]) }}" method="GET">
                            <input type="hidden" name="universe_id" value="{{ $book->book_universe_id }}">
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700">
                                Add New Page
                            </button>
                        </form>

                        <form action="{{ route('issue_pages.organizePages', ['universe_id' => $book->book_universe_id, 'book_id' => $book->id, 'issue_id' => $issue->id]) }}" method="GET">
                            <input type="hidden" name="universe_id" value="{{ $book->book_universe_id }}">
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-black text-gray-800 shadow-sm hover:bg-gray-50">
                                Organize Pages
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-gray-200 bg-gray-50 p-6 sm:p-8 lg:col-span-4 lg:border-l lg:border-t-0">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-3xl border border-gray-200 bg-white p-4 text-center shadow-sm">
                            <p class="text-2xl font-black text-gray-950">{{ $pageCount }}</p>
                            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-gray-500">Pages</p>
                        </div>
                        <div class="rounded-3xl border border-green-200 bg-green-50 p-4 text-center shadow-sm">
                            <p class="text-2xl font-black text-green-700">{{ $unlockedCount }}</p>
                            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-green-700">Open</p>
                        </div>
                        <div class="rounded-3xl border border-red-200 bg-red-50 p-4 text-center shadow-sm">
                            <p class="text-2xl font-black text-red-700">{{ $lockedCount }}</p>
                            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-red-700">Locked</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-3xl border border-indigo-100 bg-indigo-50 p-5">
                        <p class="text-sm font-black text-indigo-900">Creator Tip</p>
                        <p class="mt-2 text-sm leading-6 text-indigo-800">
                            Use page numbers to control reading order, then organize pages before final review.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pages --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Page Library</p>
                    <h2 class="mt-3 text-2xl font-black text-gray-950">Uploaded Pages</h2>
                </div>
            </div>

            @if(isset($pages) && count($pages))
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($pages as $page)
                        <div class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                            <div class="relative overflow-hidden bg-gray-100">
                                @if($page->issue_page_url)
                                    <a href="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" target="_blank">
                                        <img src="{{ Storage::disk('s3-public')->url($page->issue_page_url) }}" alt="Page {{ $page->issue_page_number }}" class="aspect-[4/5] w-full object-cover transition duration-300 group-hover:scale-105">
                                    </a>
                                @else
                                    <div class="flex aspect-[4/5] items-center justify-center p-8 text-center">
                                        <div>
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                                                </svg>
                                            </div>
                                            <p class="mt-4 text-sm font-black text-gray-900">No page image</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute left-4 top-4">
                                    @if($page->issue_page_is_locked)
                                        <button id="toggleLock{{ $page->id }}" onclick="isVisible('{{ $page->id }}', 'Unlock', {{ $book->book_universe_id }},{{ $book->id }},{{ $page->issue_id }})" type="button" class="rounded-full bg-red-50 px-3 py-1 text-xs font-black text-red-700 shadow-sm ring-1 ring-red-200">
                                            Locked
                                        </button>
                                    @else
                                        <button id="toggleLock{{ $page->id }}" onclick="isVisible('{{ $page->id }}', 'Lock', {{ $book->book_universe_id }},{{ $book->id }},{{ $page->issue_id }})" type="button" class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700 shadow-sm ring-1 ring-green-200">
                                            Unlocked
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-5 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">Page ID #{{ $page->id }}</p>
                                        <h3 class="mt-2 text-lg font-black text-gray-950">
                                            Page {{ $page->issue_page_number }}
                                        </h3>
                                    </div>

                                    <div class="min-w-28">
                                        <label for="issue_page_number{{ $page->id }}" class="sr-only">Page Number</label>
                                        <select id="issue_page_number{{ $page->id }}"
                                                onchange="swapPageNumber({{ $page->id }},{{ $book->book_universe_id }},{{ $book->id }},{{ $page->issue_id }}, 'Unlock')"
                                                name="issue_page_number"
                                                class="block w-full rounded-2xl border-0 bg-gray-50 py-2 pl-3 pr-8 text-sm font-bold text-gray-900 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-indigo-600">
                                            @foreach($issue->pages as $count)
                                                @if($count->issue_page_number == $page->issue_page_number)
                                                    <option id="{{ $count->id }}" value="{{ $count->issue_page_number }}" selected>{{ $count->issue_page_number }}</option>
                                                @else
                                                    <option id="{{ $count->id }}" value="{{ $count->issue_page_number }}">{{ $count->issue_page_number }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3 border-t border-gray-100 pt-5">
                                    <form action="{{ route('issue_pages.editPage', ['universe_id' => $book->book_universe_id, 'book_id' => $book->id, 'issue_id' => $issue->id, 'page_id' => $page->id]) }}">
                                        <input type="hidden" id="u_id{{ $page->id }}" name="u_id" value="{{ $book->book_universe_id }}">
                                        <input type="hidden" id="b_id{{ $page->id }}" name="b_id" value="{{ $book->id }}">
                                        <input type="hidden" id="i_id{{ $page->id }}" name="issue_id" value="{{ $issue->id }}">
                                        <input type="hidden" id="issue_page_id{{ $page->id }}" name="issue_page_id" value="{{ $page->id }}">
                                        <button type="submit" class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-black text-white hover:bg-indigo-700">
                                            Replace
                                        </button>
                                    </form>

                                    <button onclick="confirmDelete({{ $page->id }}, {{ $book->book_universe_id }},{{ $book->id }},{{ $page->issue_id }})" type="button" class="rounded-2xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-black text-red-700 hover:bg-red-100">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 p-10 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-black text-gray-950">No pages uploaded yet</h3>
                    <p class="mt-2 text-sm text-gray-500">Start by adding your first manga or comic page.</p>
                </div>
            @endif
        </div>
    </div>
</div>
