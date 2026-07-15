

    @php
        $series = $webSeries ?? $webisode ?? null;
        $universeId = $series->universe_id ?? $universe_id ?? request('universe_id');
        $seriesId = $series->id ?? $webisode_id ?? request('webisode_id');
        $title = $series->webisode_title ?? old('webisode_title') ?? 'Untitled Web Series';
        $description = $series->webisode_short_description ?? $series->webisode_description ?? 'No description has been added yet.';
        $creator = $series->webisode_creator ?? auth()->user()->name ?? 'Creator';
        $coverPath = $series->webisode_cover_image ?? null;
        $bannerPath = $series->webisode_banner_image ?? null;
        $coverUrl = $coverPath ? Storage::disk('s3-public')->url($coverPath) : null;
        $bannerUrl = $bannerPath ? Storage::disk('s3-public')->url($bannerPath) : null;
        $genres = $series->webisode_genres ?? [];
        $tags = $series->webisode_tags ?? [];
        if (is_string($genres)) $genres = json_decode($genres, true) ?: [];
        if (is_string($tags)) $tags = json_decode($tags, true) ?: [];
    @endphp

    <div class="bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                    @foreach([['Series Information', true], ['Artwork & Media', true], ['Review & Submit', false]] as $index => $item)
                        <div class="flex items-center gap-4 p-5">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $item[1] ? 'bg-green-100 text-green-700' : 'bg-indigo-600 text-white' }}">
                                @if($item[1])
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 5.292a1 1 0 010 1.416l-7.5 7.5a1 1 0 01-1.416 0l-3.5-3.5a1 1 0 011.416-1.416L8.5 12.086l6.796-6.794a1 1 0 011.408 0z" clip-rule="evenodd"/></svg>
                                @else
                                    <span class="text-sm font-black">3</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Step {{ $index + 1 }}</p>
                                <p class="mt-1 text-sm font-black text-gray-950">{{ $item[0] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                @if($bannerUrl)
                    <div class="absolute inset-0">
                        <img src="{{ $bannerUrl }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gray-950/75"></div>
                    </div>
                @endif
                <div class="relative grid gap-8 p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:p-10">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] {{ $bannerUrl ? 'text-indigo-300' : 'text-indigo-600' }}">Final Review</p>
                        <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-4xl {{ $bannerUrl ? 'text-white' : 'text-gray-950' }}">Your web series is almost ready</h1>
                        <p class="mt-4 max-w-2xl text-sm leading-7 {{ $bannerUrl ? 'text-gray-200' : 'text-gray-600' }}">Review your information, confirm your publishing settings, and finish the setup process.</p>
                    </div>
                    <div class="rounded-3xl border border-white/20 bg-white/95 p-5 shadow-xl backdrop-blur">
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">Setup Status</p>
                        <p class="mt-2 text-lg font-black text-gray-950">Ready to Submit</p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-red-900">Please fix the following:</h3>
                    <ul class="mt-3 space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('webisodes.store', $universe->id) }}" class="space-y-8">
                @csrf
                <input type="hidden" name="step" value="3">
                <input type="hidden" name="universe_id" value="{{ $universeId }}">
                @if($seriesId)
                    <input type="hidden" name="webisode_id" value="{{ $seriesId }}">
                @endif

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                    <div class="space-y-8 lg:col-span-8">
                        <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-6 py-5 sm:px-8">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Series Overview</p>
                                <h2 class="mt-2 text-2xl font-black text-gray-950">{{ $title }}</h2>
                            </div>
                            <div class="grid gap-8 p-6 sm:p-8 md:grid-cols-[180px_1fr]">
                                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-gray-100">
                                    @if($coverUrl)
                                        <img src="{{ $coverUrl }}" alt="{{ $title }}" class="aspect-[4/5] h-full w-full object-cover">
                                    @else
                                        <div class="flex aspect-[4/5] items-center justify-center p-6 text-center">
                                            <p class="text-xs font-black uppercase tracking-widest text-gray-500">No cover uploaded</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-6">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">Creator</p>
                                        <p class="mt-2 text-base font-black text-gray-950">{{ $creator }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">Description</p>
                                        <p class="mt-2 text-sm leading-7 text-gray-600">{{ $description }}</p>
                                    </div>
                                    @if(count($genres))
                                        <div>
                                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Genres</p>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @foreach($genres as $genre)
                                                    <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-black text-indigo-700 ring-1 ring-indigo-200">{{ is_array($genre) ? ($genre['name'] ?? '') : $genre }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if(count($tags))
                                        <div>
                                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Tags</p>
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @foreach($tags as $tag)
                                                    <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700 ring-1 ring-gray-200">#{{ is_array($tag) ? ($tag['name'] ?? '') : $tag }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>

                        <!-- <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Publishing Settings</p>
                            <h2 class="mt-3 text-2xl font-black text-gray-950">Choose how this series launches</h2>
                            <p class="mt-2 text-sm leading-6 text-gray-600">Keep it private while you work, or publish it immediately.</p>

                            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                <label class="cursor-pointer rounded-3xl border border-gray-200 bg-gray-50 p-5 hover:border-indigo-300">
                                    <div class="flex items-start gap-4">
                                        <input type="radio" name="webisode_is_active" value="0" class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" {{ old('webisode_is_published', $series->webisode_is_published ?? 0) == 0 ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-black text-gray-950">Save as draft</p>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Keep the series hidden while you continue building it.</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="cursor-pointer rounded-3xl border border-gray-200 bg-gray-50 p-5 hover:border-indigo-300">
                                    <div class="flex items-start gap-4">
                                        <input type="radio" name="webisode_is_active" value="1" class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" {{ old('webisode_is_published', $series->webisode_is_published ?? 0) == 1 ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-black text-gray-950">Publish now</p>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Make the series visible on your Enterblaze platform.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-200 p-4">
                                    <input type="hidden" name="webisode_is_featured" value="0">
                                    <input type="checkbox" name="webisode_is_featured" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" {{ old('webisode_is_featured', $series->webisode_is_featured ?? false) ? 'checked' : '' }}>
                                    <div>
                                        <p class="text-sm font-black text-gray-950">Feature this series</p>
                                        <p class="mt-1 text-xs leading-5 text-gray-500">Allow it to appear in promoted sections.</p>
                                    </div>
                                </label>

                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-200 p-4">
                                    <input type="hidden" name="webisode_is_adult" value="0">
                                    <input type="checkbox" name="webisode_is_adult" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" {{ old('webisode_is_adult', $series->webisode_is_adult ?? false) ? 'checked' : '' }}>
                                    <div>
                                        <p class="text-sm font-black text-gray-950">Adult content</p>
                                        <p class="mt-1 text-xs leading-5 text-gray-500">Mark the series for mature audiences.</p>
                                    </div>
                                </label>
                            </div>
                        </section> -->
                    </div>

                    <aside class="space-y-6 lg:col-span-4">
                        <div class="sticky top-6 space-y-6">
                            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Submission Checklist</p>
                                <div class="mt-6 space-y-4">
                                    @foreach([
                                        ['Series information added', filled($title) && $title !== 'Untitled Web Series'],
                                        ['Description added', $description !== 'No description has been added yet.'],
                                        ['Cover image uploaded', filled($coverPath)],
                                        ['Publishing choice selected', true]
                                    ] as $check)
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-xl {{ $check[1] ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                                {{ $check[1] ? '✓' : '!' }}
                                            </div>
                                            <p class="text-sm font-bold text-gray-700">{{ $check[0] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-3xl border border-indigo-200 bg-indigo-50 p-6">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Ready to Finish?</p>
                                <h3 class="mt-3 text-xl font-black text-gray-950">Submit your web series</h3>
                                <p class="mt-2 text-sm leading-6 text-gray-600">You can edit the series, add episodes, and change the publishing status later.</p>
                                <button type="submit" class="mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3.5 text-sm font-black text-white shadow-sm hover:bg-indigo-500">Submit & Finish</button>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">What happens next</p>
                                <div class="mt-4 space-y-3 text-sm leading-6 text-gray-600">
                                    <p>Your web series is saved to your admin library.</p>
                                    <p>You can begin adding episodes from its dashboard.</p>
                                    <p>Publishing controls remain editable at any time.</p>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </div>

