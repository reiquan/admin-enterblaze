<div class="min-h-screen bg-gray-50">
    {{-- Page Header --}}
    <div class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <x-application-logo class="block h-10 w-auto" />

                    <div>
                        <p class="text-sm font-medium text-indigo-600">Card Series</p>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            {{ $cardSeries->card_series_name ?? $cardSeries->card_series_title ?? 'Card Series Hub' }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage this series, upload cards, and organize your collectible universe.
                        </p>
                    </div>
                </div>

                <form action="" method="GET" class="shrink-0">
                    <input type="hidden" name="universe_id" value="{{ request('u_id') ?? request('universe_id') }}">
                    <input type="hidden" name="card_series_id" value="{{ request('c_id') ?? request('card_series_id') }}">

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        Add New Card
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Series Hero --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="grid gap-0 lg:grid-cols-[320px_1fr]">
                <div class="bg-gray-100 p-6">
                    <div class="mx-auto max-w-xs">
                        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            @if(!empty($cardSeries->card_series_image_front))
                                <a href="{{ Storage::disk('s3-public')->url($cardSeries->card_series_image_front) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3-public')->url($cardSeries->card_series_image_front) }}"
                                        alt="{{ $cardSeries->card_series_name ?? 'Card series front cover' }}"
                                        class="aspect-[4/5] w-full object-cover">
                                </a>
                            @else
                                <div class="flex aspect-[4/5] w-full items-center justify-center bg-gray-200">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75A2.25 2.25 0 0 1 6 4.5h12a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 18 19.5H6a2.25 2.25 0 0 1-2.25-2.25V6.75Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.75 15 4.5-4.5a2.25 2.25 0 0 1 3.182 0L15.75 15m-2.25-2.25 1.318-1.318a2.25 2.25 0 0 1 3.182 0L20.25 13.5" />
                                        </svg>
                                        <p class="mt-3 text-sm font-medium text-gray-500">No front cover</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if(!empty($cardSeries->card_series_image_back))
                            <a href="{{ Storage::disk('s3-public')->url($cardSeries->card_series_image_back) }}" target="_blank"
                                class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                                View Back Cover
                            </a>
                        @endif
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-700">
                                Series Control Center
                            </div>

                            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                                {{ $cardSeries->card_series_name ?? $cardSeries->card_series_title ?? 'Untitled Series' }}
                            </h2>

                            @if(!empty($cardSeries->card_series_description))
                                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-600">
                                    {{ $cardSeries->card_series_description }}
                                </p>
                            @else
                                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-600">
                                    Build out the card collection for this series. Add character cards, skill cards, location cards, relics, factions, and story-specific power scaling.
                                </p>
                            @endif
                        </div>
                    </div>

                    @php
                        $cardCollection = isset($cards) ? collect($cards) : collect();
                        $totalCards = $cardCollection->count();
                        $publishedCards = $cardCollection->filter(function ($card) {
                            return isset($card->card_is_published) && in_array($card->card_is_published, [1, '1', true, 'true', 'published', 'Published', 'yes', 'Yes'], true);
                        })->count();
                        $draftCards = max($totalCards - $publishedCards, 0);
                    @endphp

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-medium text-gray-500">Total Cards</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCards }}</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-medium text-gray-500">Published</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $publishedCards }}</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-medium text-gray-500">Drafts</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $draftCards }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards Section --}}
        <div class="mt-8">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Cards in this Series</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Review card artwork, rarity, status, and quick actions.
                    </p>
                </div>
            </div>

            @if(isset($cards) && count($cards))
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($cards as $card)
                        <div class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="relative bg-gray-100">
                                @if(!empty($card->card_image_one))
                                    <a href="{{ Storage::disk('s3-public')->url($card->card_image_one) }}" target="_blank">
                                        <img src="{{ Storage::disk('s3-public')->url($card->card_image_one) }}"
                                            alt="{{ $card->card_name ?? 'Card image' }}"
                                            class="aspect-[4/5] w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                                    </a>
                                @else
                                    <div class="flex aspect-[4/5] items-center justify-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3.75h10.5A2.25 2.25 0 0 1 19.5 6v12A2.25 2.25 0 0 1 17.25 20.25H6.75A2.25 2.25 0 0 1 4.5 18V6a2.25 2.25 0 0 1 2.25-2.25Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 8.25h7.5M8.25 12h7.5M8.25 15.75h4.5" />
                                            </svg>
                                            <p class="mt-2 text-sm font-medium text-gray-500">No image</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute left-3 top-3">
                                    <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-800 shadow-sm ring-1 ring-gray-200 backdrop-blur">
                                        {{ $card->card_rarity ?? 'Unranked' }}
                                    </span>
                                </div>

                                <div class="absolute right-3 top-3">
                                    @if(isset($card->card_is_published) && in_array($card->card_is_published, [1, '1', true, 'true', 'published', 'Published', 'yes', 'Yes'], true))
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-green-200">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700 ring-1 ring-yellow-200">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5">
                                <h4 class="line-clamp-1 text-lg font-bold text-gray-900">
                                    {{ $card->card_name ?? 'Untitled Card' }}
                                </h4>

                                @if(!empty($card->card_bio))
                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                        {{ $card->card_bio }}
                                    </p>
                                @else
                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                        No card bio has been added yet.
                                    </p>
                                @endif

                                <div class="mt-5 flex flex-wrap items-center gap-2">
                                    @if(Route::has('cards.show'))
                                        <form method="get" action="{{ route('cards.show', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}"
                                            class="inline-flex flex-1 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                            @csrf
                                            <input type="hidden" name="c_id" value="{{ $card->id }}">
                                            <button type="submit"> View</button>
                                           
                                        </form>
                                    @endif

                                    @if(Route::has('cards.edit'))
                                        <form method="get" action="{{ route('cards.create', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}"
                                        class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-gray-800">
                                            @csrf
                                            <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                            <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <button type="submit"> Edit</button>
                                        
                                    </form>
                                    @endif

                                    @if(Route::has('cards.destroy'))
                                        <form method="POST" action="{{ route('cards.destroy', ['card' => $card->id]) }}" onsubmit="return confirm('Delete this card?')" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border-2 border-dashed border-gray-300 bg-white p-10 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3.75h10.5A2.25 2.25 0 0 1 19.5 6v12A2.25 2.25 0 0 1 17.25 20.25H6.75A2.25 2.25 0 0 1 4.5 18V6a2.25 2.25 0 0 1 2.25-2.25Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8.25v7.5M8.25 12h7.5" />
                    </svg>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">No cards yet</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                        Start this series by adding your first card. You can add character cards, powers, locations, weapons, lore cards, and more.
                    </p>

                    <form action="{{ route('cards.create', ['universe_id' => request('universe_id'),'card_series_id' => $cardSeries->id] )}}" method="GET" class="mt-6">
                        <input type="hidden" name="universe_id" value="{{ request('u_id') ?? request('universe_id') }}">
                        <input type="hidden" name="card_series_id" value="{{ request('c_id') ?? request('card_series_id') }}">

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Add First Card
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
