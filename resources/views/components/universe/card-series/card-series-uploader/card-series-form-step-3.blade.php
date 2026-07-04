<div class="bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
    <form method="GET" action="{{ route('card-series.index', $universe_id) }}" class="mx-auto max-w-6xl" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="{{ $step ?? 3 }}">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-5.75a.75.75 0 001.5 0v-5a.75.75 0 00-1.5 0v5zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Please fix the following:</h3>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 bg-white px-6 py-5 sm:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium uppercase tracking-wide text-emerald-600">Step {{ $step ?? 3 }}</p>
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Review & Finish Card Series</h1>
                            </div>
                        </div>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                            Review your card series details, confirm the artwork, then finish the setup. You can go back if anything needs to be changed.
                        </p>
                    </div>

                    <div class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600">
                        Final Review
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-0 lg:grid-cols-5">
                <aside class="border-b border-gray-200 px-6 py-8 sm:px-8 lg:col-span-2 lg:border-b-0 lg:border-r">
                    <div class="sticky top-6">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Before You Finish</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Make sure the title, description, series artwork, and universe connection are correct before submitting this card series.
                        </p>

                        <div class="mt-6 rounded-xl border border-emerald-100 bg-emerald-50/70 p-4">
                            <div class="flex gap-3">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <div>
                                    <h3 class="text-sm font-semibold text-emerald-900">Almost done</h3>
                                    <p class="mt-1 text-sm leading-6 text-emerald-800">
                                        This page uses one final submit button so your review step stays clean and intentional.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Confirm the card series belongs to the right universe.</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Check the front and back card artwork.</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Finish the setup when everything looks right.</span>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="px-6 py-8 sm:px-8 lg:col-span-3">
                    <div class="space-y-6">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">Series Summary</h3>
                                        <p class="text-sm text-gray-500">Quick review of the current card series data.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-100">
                                <div class="grid grid-cols-1 gap-1 px-5 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Universe</dt>
                                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">
                                        {{ $universe->universe_name ?? $universe->name ?? 'Not selected' }}
                                    </dd>
                                </div>

                                <div class="grid grid-cols-1 gap-1 px-5 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Card Series</dt>
                                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">
                                        {{ $card_series->card_series_name ?? $card_series->name ?? 'Untitled Card Series' }}
                                    </dd>
                                </div>

                                <div class="grid grid-cols-1 gap-1 px-5 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                    <dd class="text-sm text-gray-700 sm:col-span-2">
                                        {{ $card_series->card_series_slug ?? $card_series->slug ?? 'Not set' }}
                                    </dd>
                                </div>

                                <div class="grid grid-cols-1 gap-1 px-5 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="sm:col-span-2">
                                        @php
                                            $publishedStatus = $card_series->card_series_is_published ?? $card_series->is_published ?? null;
                                        @endphp

                                        @if ($publishedStatus === true || $publishedStatus === 1 || $publishedStatus === '1' || $publishedStatus === 'published')
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Published</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Draft</span>
                                        @endif
                                    </dd>
                                </div>

                                <div class="grid grid-cols-1 gap-1 px-5 py-4 sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="text-sm leading-6 text-gray-700 sm:col-span-2">
                                        {{ $card_series->card_series_description ?? $card_series->description ?? 'No description has been added yet.' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                                    <h3 class="text-base font-semibold text-gray-900">Front Card Cover</h3>
                                    <p class="text-sm text-gray-500">Main artwork preview.</p>
                                </div>
                                <div class="p-5">
                                    @if (!empty($card_series->card_series_image_front))
                                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-100">
                                            <img src="{{ Storage::disk('s3-public')->url($card_series->card_series_image_front) }}" alt="Front card cover" class="h-72 w-full object-cover">
                                        </div>
                                    @else
                                        <div class="flex h-72 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 text-center">
                                            <div>
                                                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                                </svg>
                                                <p class="mt-3 text-sm font-medium text-gray-700">No front cover uploaded</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                                    <h3 class="text-base font-semibold text-gray-900">Back Card Cover</h3>
                                    <p class="text-sm text-gray-500">Reverse artwork preview.</p>
                                </div>
                                <div class="p-5">
                                    @if (!empty($card_series->card_series_image_back))
                                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-100">
                                            <img src="{{ Storage::disk('s3-public')->url($card_series->card_series_image_back) }}" alt="Back card cover" class="h-72 w-full object-cover">
                                        </div>
                                    @else
                                        <div class="flex h-72 items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50 text-center">
                                            <div>
                                                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0-4.5-5.571 3m0 0-5.571-3m5.571 3v8.25" />
                                                </svg>
                                                <p class="mt-3 text-sm font-medium text-gray-700">No back cover uploaded</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">Finish card series setup</h3>
                                    <p class="mt-1 text-sm text-gray-500">Submit this final step when everything looks correct.</p>
                                </div>

                                <div class="flex flex-col gap-3 sm:flex-row">
                                    <!-- <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                        </svg>
                                        Back
                                    </a> -->

                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                        Submit Review & Finish
                                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18.75 19.5 5.25" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
</div>
