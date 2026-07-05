<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">
                    Card Builder
                </p>
                <h2 class="mt-1 text-xl font-semibold leading-tight text-gray-900">
                    @if($card_id)
                        {{ __('Edit Your Card') }}
                    @else
                        {{ __('Create Your Card') }}
                    @endif
                </h2>
            </div>

            <a href="{{ route('card-series.index', $universe->id ?? $universe_id) }}"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                Back to Series
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-gray-200">

                @include('components.universe.card-series.cards.progress')

                <div class="bg-gray-50 px-6 py-8 sm:px-8">
                    @if($step !== 1)

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                            @include('components.universe.card-series.cards.card-uploader.card-form-step-'.$step)
                        </div>

                    @else

                        <form method="POST" action="{{ route('cards.store', ['universe_id' => $universe->id, 'card_series_id' => $card_series_id,]) }}">
                            @csrf

                            <input type="hidden" name="step" value="1">
                            <input type="hidden" name="universe_id" value="{{ $universe->id }}">
                            @if($card_id)
                            <input type="hidden" name="card_id" value="{{ $card->id }}">
                            @endif

                            @if ($errors->any())
                                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-6 w-6 flex-none items-center justify-center rounded-full bg-red-100 text-sm font-bold">
                                            !
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold">Please fix the following:</h3>
                                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="grid gap-8 lg:grid-cols-12">
                                <aside class="lg:col-span-4">
                                    <div class="sticky top-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3h10.5a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25V5.25Z" />
                                            </svg>
                                        </div>

                                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                                            Series Foundation
                                        </h3>
                                        <p class="mt-2 text-sm leading-6 text-gray-500">
                                            Start with the details readers will see first: title, creator, type, audience, and a strong summary.
                                        </p>

                                        <div class="mt-6 rounded-xl bg-gray-50 p-4">
                                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">
                                                Tip
                                            </p>
                                            <p class="mt-2 text-sm text-gray-600">
                                                Use a clear title and a short summary that explains the hook of the series quickly.
                                            </p>
                                        </div>
                                    </div>
                                </aside>

                                <section class="lg:col-span-8">
                                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                                        <div class="border-b border-gray-200 pb-6">
                                            <h2 class="text-xl font-bold text-gray-900">
                                                @if($card_id)
                                                    {{ __('Edit Your Card') }}
                                                @else
                                                    {{ __('Create Your Card') }}
                                                @endif
                                            </h2>
                                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                                This information may be displayed publicly, so make sure everything is accurate before moving forward.
                                            </p>
                                        </div>

                                        <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-7 sm:grid-cols-6">
                                            <div class="sm:col-span-4">
                                                <label for="card_name" class="block text-sm font-semibold text-gray-900">
                                                   Card Name
                                                </label>
                                                <div class="mt-2">
                                                    <input type="text"
                                                           name="card_name"
                                                           value ="{{ $card_id ? $card->card_name : ''}}"
                                                           id="card_name"
                                                           autocomplete="card_name"
                                                           value="{{ old('card_name') }}"
                                                           class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                                           placeholder="Example: Reiden Tapped In">
                                                </div>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="card_price" class="block text-sm font-semibold text-gray-900">
                                                    Price
                                                </label>
                                                <div class="mt-2">
                                                    <input type="number"
                                                           name="card_price"
                                                           value ="{{ $card_id ? $card->card_price : ''}}"
                                                           id="card_price"
                                                           autocomplete="card_price"
                                                           value="{{ old('card_price') }}"
                                                           class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                                           >
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="card_published_at" class="block text-sm font-semibold text-gray-900">
                                                    Publication Date
                                                </label>
                                                <div class="mt-2">
                                                    <input type="date"
                                                           name="card_published_at"
                                                           id="card_published_at"
                                                           value="{{ $formattedDate ?? now()->format('Y-m-d') }}"
                                                           autocomplete="card_published_at"
                                                           value="{{ old('card_published_at') }}"
                                                           class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="card_era_id" class="block text-sm font-semibold text-gray-900">
                                                    Card Series Era
                                                </label>
                                                <div class="mt-2">
                                                    <select id="card_era_id"
                                                            name="card_era_id"
                                                            value ="{{ $card_id ? $card->card_era_id : ''}}"
                                                            autocomplete="card_era_id"
                                                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                            @foreach($eras as $era)
                                                                <option value="{{$era['id']}}" @selected(old('card_era_id') === '')>{{$era['card_era_name']}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="card_rarity" class="block text-sm font-semibold text-gray-900">
                                                    Card Rarity
                                                </label>
                                                <div class="mt-2">
                                                    <select id="card_rarity"
                                                            name="card_rarity"
                                                            value ="{{ $card_id ? $card->card_rarity : ''}}"
                                                            autocomplete="card_rarity"
                                                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                            <option value="Legendary" @selected(old('card_rarity') === '')>Legendary</option>
                                                            <option value="Exclusive" @selected(old('card_rarity') === '')>Exclusive</option>
                                                            <option value="Normal" @selected(old('card_rarity') === '')>Normal</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="sm:col-span-3">
                                                <label for="card_type_id" class="block text-sm font-semibold text-gray-900">
                                                    Card Series Type
                                                </label>
                                                <div class="mt-2">
                                                    <select id="card_type_id"
                                                            name="card_type_id"
                                                            value ="{{ $card_id ? $card->card_type_id : ''}}"
                                                            autocomplete="card_type_id"
                                                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                            @foreach($card_types as $type)
                                                                <option value="{{$type['id']}}" @selected(old('card_type_id') === '')>{{$type['card_type_name']}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if(!$card_factions->isEmpty())
                                              <div class="sm:col-span-3">
                                                  <label for="card_faction_id" class="block text-sm font-semibold text-gray-900">
                                                      Card Faction
                                                  </label>
                                                  <div class="mt-2">
                                                      <select id="card_faction_id"
                                                              name="card_faction_id"
                                                              value ="{{ $card_id ? $card->card_faction_id : ''}}"
                                                              autocomplete="card_faction_id"
                                                              class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                              @foreach($card_factions as $faction)
                                                                  @if($faction->id == $card->card_faction_id)
                                                                    <option value="{{$faction['id']}}" @selected(old('card_faction_id') === '') selected>{{$faction['card_faction_name']}}</option>
                                                                    @else
                                                                    <option value="{{$faction['id']}}" @selected(old('card_faction_id') === '')>{{$faction['card_faction_name']}}</option>
                                                                    @endif
                                                              @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                            @endif

                                            <div class="sm:col-span-3">
                                                <label for="card_tier_id" class="block text-sm font-semibold text-gray-900">
                                                    Card Tiers
                                                </label>
                                                <div class="mt-2">
                                                    <select id="card_tier_id"
                                                            name="card_tier_id"
                                                            value ="{{ $card_id ? $card->card_tier_id : ''}}"
                                                            autocomplete="card_tier_id"
                                                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                                            @foreach($card_tiers as $tier)
                                                                @if($tier->id == $card->card_tier_id)
                                                                <option value="{{$tier['id']}}" @selected(old('card_tier_id') === '') selected>{{$tier['card_tier_name']}}</option>
                                                                @else
                                                                <option value="{{$tier['id']}}" @selected(old('card_tier_id') === '')>{{$tier['card_tier_name']}}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-span-full">
                                                <label for="card_bio" class="block text-sm font-semibold text-gray-900">
                                                    Card Summary
                                                </label>
                                                <div class="mt-2">
                                                    <textarea id="card_bio"
                                                              name="card_bio"
                                                              value ="{{ $card_id ? $card->card_bio : ''}}"
                                                              rows="5"
                                                              class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                                              placeholder="Write a few sentences about this book, manga, or card series.">{{ $card_id ? $card->card_bio : old('card_description') }}</textarea>
                                                </div>
                                                <p class="mt-3 text-sm leading-6 text-gray-500">
                                                    A strong summary helps users understand the tone, setting, and reason to keep reading.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">
                                            <a href="{{ route('card-series.index', $universe->id) }}"
                                               class="inline-flex justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                                                Cancel
                                            </a>

                                            <button type="submit"
                                                    class="inline-flex justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Save and Continue
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
