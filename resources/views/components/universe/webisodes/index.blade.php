

    <div class="bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Hero --}}
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="relative isolate p-6 sm:p-8 lg:p-10">
                    <div class="absolute right-0 top-0 -z-10 h-40 w-40 rounded-full bg-indigo-100 blur-3xl"></div>
                    <div class="absolute bottom-0 left-20 -z-10 h-32 w-32 rounded-full bg-purple-100 blur-3xl"></div>

                    <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-3xl">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Enterblaze Admin</p>
                            <h1 class="mt-4 text-3xl font-black tracking-tight text-gray-950 sm:text-5xl">
                                Web Series Library
                            </h1>
                            <p class="mt-4 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base">
                                Build out your digital series catalog with polished covers, episode management, reader visibility, and creator-ready publishing controls.
                            </p>
                        </div>

                        @if(isset($webisodes))
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:w-[520px]">
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Total</p>
                                    <p class="mt-2 text-2xl font-black text-gray-950">{{ $webisodes->count() ?? 0 }}</p>
                                </div>
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Published</p>
                                    <p class="mt-2 text-2xl font-black text-green-700">{{ $webisodes->where('webisode_is_active', 1)->count() ?? 0 }}</p>
                                </div>
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Drafts</p>
                                    <p class="mt-2 text-2xl font-black text-orange-600">{{ $webisodes->where('webisode_is_active', 0)->count() ?? 0 }}</p>
                                </div>
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4">
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Locked</p>
                                    <p class="mt-2 text-2xl font-black text-red-600">{{ $webisodes->where('is_locked', 1)->count() ?? 0 }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Filters / Search --}}
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <form method="GET" action="{{ route('webisodes.index', $universe[0]['id'] ?? $universe->id) }}" class="grid grid-cols-1 gap-4 lg:grid-cols-12 lg:items-end">
                    <div class="lg:col-span-5">
                        <label for="search" class="block text-sm font-bold text-gray-900">Search Series</label>
                        <input id="search" name="search" type="text" value="{{ request('search') }}"
                               placeholder="Search by title, creator, genre..."
                               class="mt-2 block w-full rounded-2xl border-gray-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="lg:col-span-3">
                        <label for="status" class="block text-sm font-bold text-gray-900">Status</label>
                        <select id="status" name="status" class="mt-2 block w-full rounded-2xl border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="published" @selected(request('status') === 'published')>Published</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="locked" @selected(request('status') === 'locked')>Locked</option>
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <label for="sort" class="block text-sm font-bold text-gray-900">Sort</label>
                        <select id="sort" name="sort" class="mt-2 block w-full rounded-2xl border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>Oldest</option>
                            <option value="title" @selected(request('sort') === 'title')>Title</option>
                        </select>
                    </div>

                    <div class="flex gap-3 lg:col-span-2">
                        <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white hover:bg-indigo-500">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Series Grid --}}
            @if(isset($webisodes) && $webisodes->count())
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($webisodes as $series)
                        <div class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                                @if(!empty($series->webisode_cover_image))
                                    <img src="{{ Storage::disk('s3-public')->url($series->webisode_cover_image) }}"
                                         alt="{{ $series->webisode_title ?? 'Web series cover' }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <div class="text-center">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 8.25h16.5M7.5 3.75v16.5M16.5 3.75v16.5" />
                                                </svg>
                                            </div>
                                            <p class="mt-3 text-sm font-black text-gray-500">No Cover</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                    @if(!empty($series->webisode_is_active))
                                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700 ring-1 ring-green-200">Published</span>
                                    @else
                                        <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-700 ring-1 ring-orange-200">Draft</span>
                                    @endif

                                    @if(!empty($series->is_locked))
                                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-black text-red-700 ring-1 ring-red-200">Locked</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                                            {{ $series->genre ?? $series->webisode_genre ?? 'Web Series' }}
                                        </p>
                                        <h3 class="mt-2 line-clamp-1 text-xl font-black text-gray-950">
                                            {{ $series->title ?? $series->webisode_title ?? 'Untitled Series' }}
                                        </h3>
                                    </div>

                                    <span class="rounded-2xl border border-gray-200 bg-gray-50 px-3 py-2 text-xs font-black text-gray-600">
                                        #{{ $series->id }}
                                    </span>
                                </div>

                                <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600">
                                    {{ $series->description ?? $series->webisode_description ?? 'Add a description to help readers understand the vibe, story, and universe of this series.' }}
                                </p>

                                <div class="mt-5 grid grid-cols-3 gap-3">
                                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Episodes</p>
                                        <p class="mt-1 text-lg font-black text-gray-950">{{ $series->webisode_episodes_count ?? $series->issues_count ?? 0 }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Views</p>
                                        <p class="mt-1 text-lg font-black text-gray-950">{{ number_format($series->webisode_views_count ?? 0) }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-3">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Updated</p>
                                        <p class="mt-1 text-sm font-black text-gray-950">{{ optional($series->updated_at)->format('M d') }}</p>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-wrap gap-3">
                                    <a href="{{ route('webisodes.show',['universe_id' => $universe[0]['id'] ?? $universe->id, 'webisode_id' => $series->id]) }}"
                                       class="flex-1 rounded-2xl border border-gray-300 bg-white px-4 py-3 text-center text-sm font-black text-gray-700 hover:bg-gray-50">
                                        View
                                    </a>

                                    <a href="{{ route('webisodes.edit', ['universe_id' => $universe[0]['id'] ?? $universe->id, 'webisode_id' => $series->id]) }}"
                                       class="flex-1 rounded-2xl bg-indigo-600 px-4 py-3 text-center text-sm font-black text-white hover:bg-indigo-500">
                                        Manage Videos
                                    </a>
                                </div>

                                <div class="mt-3 flex gap-3">
                                    <form method="POST" action="{{ route('webisodes.delete',['universe_id' => $universe[0]['id'] ?? $universe->id, 'webisode_id' => $series->id]) }}" onsubmit="return confirm('Delete this web series? This cannot be undone.');" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-black text-red-700 hover:bg-red-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(method_exists($webisodes, 'links'))
                    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                        {{ $webisodes->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-3xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-2xl font-black text-gray-950">No web series yet</h3>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-gray-600">
                        Start your first serialized story and build out episodes, covers, reader previews, and publishing controls.
                    </p>
                    <a href="{{ route('webisodes.create', $universe[0]['id'] ?? $universe->id) }}"
                       class="mt-6 inline-flex rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white hover:bg-indigo-500">
                        Create Your First Web Series
                    </a>
                </div>
            @endif
        </div>
    </div>

