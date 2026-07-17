<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black leading-tight text-gray-900">
                {{ __('Create Your Story') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">

                {{-- Hero --}}
                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    <div class="relative isolate p-8 sm:p-10">
                        <div class="absolute right-0 top-0 -z-10 h-40 w-40 rounded-full bg-indigo-100 blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -z-10 h-32 w-32 rounded-full bg-purple-100 blur-3xl"></div>

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.35em] text-indigo-600">Enterblaze Story Builder</p>
                                <h1 class="mt-4 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                    Create Your Story
                                </h1>
                                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                    Launch your manga, comic, novel, or web series inside your Enterblaze universe. Start with the core book details, then continue to cover art and publishing.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <span class="inline-flex items-center rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-2 text-sm font-bold text-indigo-700">
                                    Step {{ $step ?? 1 }} of 3
                                </span>
                                @isset($universe)
                                    <span class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm">
                                        Universe #{{ $universe->id }}
                                    </span>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-3xl border {{ ($step ?? 1) >= 1 ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-white' }} p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ ($step ?? 1) >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-black">1</div>
                            <div>
                                <p class="text-sm font-black text-gray-950">Story Details</p>
                                <p class="mt-1 text-xs text-gray-500">Title, creator, audience</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border {{ ($step ?? 1) >= 2 ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-white' }} p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ ($step ?? 1) >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-black">2</div>
                            <div>
                                <p class="text-sm font-black text-gray-950">Cover Art</p>
                                <p class="mt-1 text-xs text-gray-500">Upload your book image</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border {{ ($step ?? 1) >= 3 ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-white' }} p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ ($step ?? 1) >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-black">3</div>
                            <div>
                                <p class="text-sm font-black text-gray-950">Submit</p>
                                <p class="mt-1 text-xs text-gray-500">Review and publish</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($step !== 1)
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm lg:p-8">
                        @include('components.universe.books.book-uploader.book-form-step-'.$step)
                    </div>
                @else
                    <form method="POST" action="{{ route('books.store', $universe->id) }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="step" value="1">
                        <input type="hidden" name="universe_id" value="{{ $universe->id }}">
                        <input type="hidden" name="book_id" value="{{ $book->id ?? null}}">

                        @if ($errors->any())
                            <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                                <div class="flex gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-700">
                                        !
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-black text-red-900">Please fix the following before continuing:</h3>
                                        <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-100 p-6 sm:p-8">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Step 1</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-gray-950">Book Information</h2>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                                    This information will be shown publicly on your Enterblaze storefront and story pages.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-8 p-6 sm:p-8 lg:grid-cols-3">
                                <div class="lg:col-span-2">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <label for="book_title" class="block text-sm font-bold text-gray-900">Book Title</label>
                                            <input type="text" name="book_title" id="book_title" autocomplete="book_title" placeholder="Example: Reiden Tapped In" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="book_subtitle" class="block text-sm font-bold text-gray-900">Subtitle</label>
                                            <input type="text" name="book_subtitle" id="book_subtitle" autocomplete="book_subtitle" placeholder="A short hook for this book" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="book_creator" class="block text-sm font-bold text-gray-900">Creator</label>
                                            <input type="text" name="book_creator" id="book_creator" autocomplete="book_creator" placeholder="Creator name" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="book_published_at" class="block text-sm font-bold text-gray-900">Publication Date</label>
                                            <input type="date" name="book_published_at" id="book_published_at" autocomplete="book_published_at" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="book_description" class="block text-sm font-bold text-gray-900">Story Synopsis</label>
                                            <textarea id="book_description" name="book_description" rows="7" placeholder="Write a few sentences that introduce the world, conflict, and why readers should care." class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            <p class="mt-2 text-xs text-gray-500">Keep it strong, clear, and exciting. This is your reader-facing pitch.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div class="rounded-3xl border border-gray-200 bg-gray-50 p-6">
                                        <h3 class="text-sm font-black text-gray-950">Publishing Settings</h3>
                                        <p class="mt-1 text-xs leading-5 text-gray-500">Classify this book so it appears correctly across your platform.</p>

                                        <div class="mt-6 space-y-5">
                                            <div>
                                                <label for="book_type" class="block text-sm font-bold text-gray-900">Book Type</label>
                                                <select id="book_type" name="book_type" autocomplete="book_type" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option>Web Comic</option>
                                                    <option>Manga</option>
                                                    <option>Comic Book</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="book_audience" class="block text-sm font-bold text-gray-900">Audience</label>
                                                <select id="book_audience" name="book_audience" autocomplete="book_audience" class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option>Teens</option>
                                                    <option>Mature Audience</option>
                                                    <option>Adults Only</option>
                                                </select>
                                            </div>
                                            <div class="relative">
                                                <label for="book_audience" class="block text-sm font-bold text-gray-900">Book Price</label>
                                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-sm font-bold text-gray-400">$</span>
                                                <input
                                                    type="number"
                                                    name="book_price"
                                                    id="book_price"
                                                    autocomplete="book_price"
                                                    min="5.00"
                                                    step="0.01"
                                                    class="block w-full rounded-2xl border-0 bg-white py-3 pl-8 pr-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                                    placeholder="25.00"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Creator Tip</p>
                                        <p class="mt-3 text-sm leading-6 text-indigo-950">
                                            A strong title, subtitle, and synopsis will make your story easier to promote across Enterblaze, events, cards, and future reader campaigns.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm hover:bg-gray-50">
                                Cancel
                            </a>

                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save & Continue
                                <span class="ml-2">→</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
