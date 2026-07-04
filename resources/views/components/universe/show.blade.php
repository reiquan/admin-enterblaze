<div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
    {{-- Universe Hero --}}
    <div class="relative overflow-hidden border-b border-gray-200 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 p-6 text-white lg:p-8">
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-56 w-56 rounded-full bg-red-500/20 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-3 shadow-lg backdrop-blur">
                    <x-application-logo class="block h-12 w-auto text-white" />
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-indigo-200">
                        Universe Control Center
                    </p>

                    <h1 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                        {{ $universe->universe_name ?? 'Your Universe' }}
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-300">
                        Manage your books, cards, lore, characters, locations, and creative assets from one clean Jetstream dashboard.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('books.index', $universe->id) }}"
                   class="inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-bold text-gray-950 shadow-sm transition hover:bg-gray-100">
                    Open Books
                    <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 0 1 .75-.75h6.638L10.23 7.29a.75.75 0 1 1 1.04-1.08l3.5 3.25a.75.75 0 0 1 0 1.08l-3.5 3.25a.75.75 0 1 1-1.04-1.08l2.158-1.96H5.75A.75.75 0 0 1 5 10Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="{{ route('card-series.index', $universe->id) }}"
                   class="inline-flex items-center rounded-xl border border-white/15 bg-white/10 px-4 py-2 text-sm font-bold text-white shadow-sm backdrop-blur transition hover:bg-white/20">
                    Manage Cards
                </a>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 gap-4 border-b border-gray-200 bg-gray-50 p-6 lg:grid-cols-4 lg:p-8">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Books</p>
            <p class="mt-2 text-3xl font-black text-gray-900">{{ $bookCount ?? '—' }}</p>
            <p class="mt-1 text-xs text-gray-500">Stories and chapters</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Cards</p>
            <p class="mt-2 text-3xl font-black text-gray-900">{{ $cardCount ?? '—' }}</p>
            <p class="mt-1 text-xs text-gray-500">Playable collectibles</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Characters</p>
            <p class="mt-2 text-3xl font-black text-gray-900">{{ $characterCount ?? '—' }}</p>
            <p class="mt-1 text-xs text-gray-500">Heroes and villains</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Locations</p>
            <p class="mt-2 text-3xl font-black text-gray-900">{{ $locationCount ?? '—' }}</p>
            <p class="mt-1 text-xs text-gray-500">Worldbuilding zones</p>
        </div>
    </div>

    {{-- Main Actions --}}
    <div class="grid grid-cols-1 gap-6 bg-white p-6 lg:grid-cols-2 lg:p-8">
        <a href="{{ route('books.index', $universe->id) }}"
           class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-xl">
            <div class="flex items-start justify-between gap-4">
                <div class="rounded-2xl bg-indigo-50 p-3 text-indigo-700 ring-1 ring-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-500 transition group-hover:bg-indigo-600 group-hover:text-white">
                    Library
                </span>
            </div>

            <h2 class="mt-5 text-2xl font-black text-gray-900">
                Your Books
            </h2>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Organize your manga, comics, novels, volumes, chapters, and written story content for this universe.
            </p>

            <div class="mt-6 inline-flex items-center text-sm font-bold text-indigo-700">
                View books
                <svg class="ml-2 h-4 w-4 transition group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 0 1 .75-.75h6.638L10.23 7.29a.75.75 0 1 1 1.04-1.08l3.5 3.25a.75.75 0 0 1 0 1.08l-3.5 3.25a.75.75 0 1 1-1.04-1.08l2.158-1.96H5.75A.75.75 0 0 1 5 10Z" clip-rule="evenodd" />
                </svg>
            </div>
        </a>

        <a href="{{ route('card-series.index', $universe->id) }}"
           class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-red-200 hover:shadow-xl">
            <div class="flex items-start justify-between gap-4">
                <div class="rounded-2xl bg-red-50 p-3 text-red-700 ring-1 ring-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                    </svg>
                </div>

                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-500 transition group-hover:bg-red-700 group-hover:text-white">
                    RPG Tools
                </span>
            </div>

            <h2 class="mt-5 text-2xl font-black text-gray-900">
                Your Cards
            </h2>

            <p class="mt-3 text-sm leading-6 text-gray-600">
                Build characters, skills, locations, items, tiers, eras, and collectible cards tied to your universe.
            </p>

            <div class="mt-6 inline-flex items-center text-sm font-bold text-red-700">
                Manage cards
                <svg class="ml-2 h-4 w-4 transition group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 0 1 .75-.75h6.638L10.23 7.29a.75.75 0 1 1 1.04-1.08l3.5 3.25a.75.75 0 0 1 0 1.08l-3.5 3.25a.75.75 0 1 1-1.04-1.08l2.158-1.96H5.75A.75.75 0 0 1 5 10Z" clip-rule="evenodd" />
                </svg>
            </div>
        </a>
    </div>

    {{-- Coming Soon Modules --}}
    <div class="border-t border-gray-200 bg-gray-50 p-6 lg:p-8">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-gray-500">Next build areas</p>
                <h3 class="mt-2 text-xl font-black text-gray-900">Expand this universe</h3>
            </div>

            <p class="text-sm text-gray-500">Add routes for these modules as your app grows.</p>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 md:grid-cols-3 xl:grid-cols-6">
            @foreach ([
                ['label' => 'Characters', 'icon' => 'Users'],
                ['label' => 'Locations', 'icon' => 'Map'],
                ['label' => 'Factions', 'icon' => 'Shield'],
                ['label' => 'Timeline', 'icon' => 'Clock'],
                ['label' => 'Lore', 'icon' => 'Archive'],
                ['label' => 'Publish', 'icon' => 'Rocket'],
            ] as $module)
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-4 text-center shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">{{ $module['icon'] }}</p>
                    <p class="mt-2 text-sm font-bold text-gray-800">{{ $module['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
