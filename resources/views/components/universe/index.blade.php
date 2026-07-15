<div class="bg-white">
    <div class="border-b border-gray-200 bg-white px-6 py-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v13.452c0 .54-.384 1.006-.917 1.096A48.323 48.323 0 0 1 12 20.25c-2.755 0-5.455-.232-8.083-.678A1.096 1.096 0 0 1 3 18.476V4.774c0-.54.384-1.006.917-1.096A48.323 48.323 0 0 1 12 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h4.5v4.5h-4.5v-4.5Z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Universe Library</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Manage your creative worlds</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                        Create, publish, and organize the story universes that power your books, cards, characters, and lore.
                    </p>
                </div>
            </div>

            <a href="{{ route('universe.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Universe
            </a>
        </div>
    </div>

    <div class="px-6 py-8 lg:px-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Universes</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $universes->count() }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Published</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $universes->where('universe_is_active', true)->count() }}</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Drafts</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $universes->where('universe_is_active', false)->count() }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 transition hover:border-indigo-300 hover:bg-indigo-50/40">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-gray-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Start a new universe</h2>
                        <p class="mt-1 text-sm text-gray-500">Add a fresh world and connect books, cards, locations, powers, and story lore.</p>
                    </div>
                </div>

                <a href="{{ route('universe.create') }}"
                   class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                    New Universe
                </a>
            </div>
        </div>

        <div class="mt-8">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Your Universes</h2>
                    <p class="mt-1 text-sm text-gray-500">Open a universe to manage its creative assets.</p>
                </div>
            </div>

            @if($universes->count())
                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($universes as $universe)
                        <li class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <a href="{{ route('universe.show', $universe->id) }}" class="block">
                                <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                                    @if($universe->universe_logo)
                                        <img src="{{ Storage::disk('s3-public')->url($universe->universe_logo) }}"
                                             alt="{{ $universe->universe_name }} logo"
                                             class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-14 w-14 text-indigo-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v13.452c0 .54-.384 1.006-.917 1.096A48.323 48.323 0 0 1 12 20.25c-2.755 0-5.455-.232-8.083-.678A1.096 1.096 0 0 1 3 18.476V4.774c0-.54.384-1.006.917-1.096A48.323 48.323 0 0 1 12 3Z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute left-4 top-4">
                                        @if($universe->universe_is_active)
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">Published</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">Draft</span>
                                        @endif
                                    </div>
                                </div>
                            </a>

                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold tracking-tight text-gray-900">
                                            <a href="{{ route('universe.show', $universe->id) }}" class="hover:text-indigo-600">
                                                {{ $universe->universe_name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-xs text-gray-400">Slug: {{ $universe->universe_slug_name }}</p>
                                    </div>
                                </div>

                                <input type="hidden" id="{{ $universe->universe_slug_name }}" value="{{ $universe->id }}">

                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    @if($universe->universe_is_active)
                                        <button type="button"
                                                onclick="publishAction('unpublish', '{{ $universe->universe_slug_name }}')"
                                                class="inline-flex items-center justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                            Un-publish
                                        </button>
                                    @else
                                        <button type="button"
                                                onclick="publishAction('publish', '{{ $universe->universe_slug_name }}')"
                                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                                            Publish
                                        </button>
                                    @endif

                                    <button type="button"
                                            onclick="editAction('{{ $universe->id }}')"
                                            class="inline-flex items-center justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="rounded-2xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-base font-semibold text-gray-900">No universes yet</h3>
                    <p class="mt-2 text-sm text-gray-500">Create your first universe to start building your story library.</p>
                    <a href="{{ route('universe.create') }}"
                       class="mt-5 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                        Create Universe
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
