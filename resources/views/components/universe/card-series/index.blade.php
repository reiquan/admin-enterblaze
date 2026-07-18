@props([
    'universe',
    'cardSeries' => collect(),
])

<div class="bg-white">
    <div class="border-b border-gray-200 bg-white px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5Z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Card Series Library</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        {{ $universe->universe_name }} Card Series
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                        Create, publish, edit, and organize every collectible card series connected to this universe.
                    </p>
                </div>
            </div>

            <form action="{{ route('card-series.create', ['universe_id' => $universe->id]) }}" method="GET">
                <input type="hidden" name="universe_id" value="{{ $universe->id }}">

                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add New Card Series
                </button>
            </form>
        </div>
    </div>

    <div class="px-6 py-8 lg:px-8">
        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <p class="text-sm font-medium text-gray-500">Total Series</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $cardSeries->count() }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <p class="text-sm font-medium text-gray-500">Published</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $cardSeries->where('card_series_is_active', true)->count() }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <p class="text-sm font-medium text-gray-500">Drafts</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $cardSeries->where('card_series_is_active', false)->count() }}</p>
            </div>
        </div>

        @if($cardSeries->count())
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($cardSeries as $series)
                    <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="relative bg-gray-100">
                            @if(isset($series->card_series_image_front))
                                <a href="{{ Storage::disk('s3-public')->url($series->card_series_image_front) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3-public')->url($series->card_series_image_front) }}" alt="{{ $series->card_series_name }}" class="h-64 w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                                </a>
                            @else
                                <div class="flex h-64 w-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="absolute left-4 top-4">
                                @if(isset($series->card_series_is_active))
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                        Draft
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Series #{{ $series->id }}</p>
                                    <h2 class="mt-1 text-xl font-bold text-gray-900">
                                        {{ $series->card_series_name }}
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Universe: {{ $series->universe->universe_name }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-3">
                                @if($series->card_series_is_active)
                                    <button type="button" onclick="publishAction('unpublish', '{{ $series->card_series_slug_name }}', '{{ $series->id }}')" class="inline-flex items-center justify-center rounded-xl bg-yellow-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                        Unpublish
                                    </button>
                                @else
                                    <button type="button" onclick="publishAction('publish', '{{ $series->card_series_slug_name }}', '{{ $series->id }}')" class="inline-flex items-center justify-center rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Publish
                                    </button>
                                @endif

                                <form action="{{ route('card-series.edit', ['universe_id' => $series->universe->id, 'card_series_id' => $series->id]) }}">
                                    <input type="hidden" id="u_id{{ $series->id }}" name="u_id" value="{{ $series->universe->id }}">
                                    <input type="hidden" id="c_id{{ $series->id }}" name="c_id" value="{{ $series->id }}">
                                    <button type="submit" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Edit
                                    </button>
                                </form>
                            </div>

                            <div class="mt-3 grid grid-cols-2 gap-3">
                                <form action="{{ route('card-series.show', ['universe_id' => $series->universe->id, 'card_series_id' => $series->id]) }}">
                                    <input type="hidden" id="u_id{{ $series->id }}" name="u_id" value="{{ $series->universe->id }}">
                                    <input type="hidden" id="c_id{{ $series->id }}" name="c_id" value="{{ $series->id }}">
                                    <button type="submit" class="w-full rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                        View
                                    </button>
                                </form>

                                <button type="button" onclick="confirmDelete('{{ $series->id }}')" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5Z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">No card series yet</h3>
                <p class="mt-2 text-sm text-gray-500">Start by creating your first card series for this universe.</p>

                <form action="{{ route('card-series.create', ['universe_id' => $universe->id]) }}" method="GET" class="mt-6">
                    <input type="hidden" name="universe_id" value="{{ $universe->id }}">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Add New Card Series
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
