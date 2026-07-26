{{-- OTHER CREATOR UNIVERSES --}}
<section class="mt-12">
    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        {{-- Header --}}
        <div class="border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-purple-50 text-purple-600 ring-1 ring-purple-100">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.205-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.941 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-purple-600">
                            Platform Moderation
                        </p>

                        <h2 class="mt-1 text-xl font-bold tracking-tight text-gray-900">
                            Other Creator Universes
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                            Review universes belonging to other creators and control whether they are published on Enterblaze.
                        </p>
                    </div>
                </div>

                <div class="inline-flex items-center rounded-xl bg-gray-50 px-4 py-2 ring-1 ring-gray-200">
                    <span class="text-sm font-semibold text-gray-500">
                        Total:
                    </span>

                    <span class="ml-2 text-sm font-black text-gray-900">
                        {{ collect($otherUniverses ?? [])->count() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Universe List --}}
        <div class="p-6 sm:p-8">
            @if(collect($otherUniverses ?? [])->isNotEmpty())
                <div class="space-y-4">
                    @foreach($otherUniverses as $other_universe)
 
                        @php
                            $otherUniverseId = data_get($other_universe, 'id');
                            $otherUniverseName = data_get(
                                $other_universe,
                                'universe_name',
                                'Untitled Universe'
                            );

                            $otherUniverseSlug = data_get(
                                $other_universe,
                                'universe_slug_name'
                            );

                            $otherUniverseLogo = data_get(
                                $other_universe,
                                'universe_logo'
                            );

                            $otherUniverseDescription = data_get(
                                $other_universe,
                                'universe_description'
                            );

                            $otherUniverseIsActive = (bool) data_get(
                                $other_universe,
                                'universe_is_active',
                                false
                            );

                            $otherUniverseCreator = data_get(
                                $other_universe,
                                'user.name'
                            ) ?? data_get(
                                $other_universe,
                                'creator.name'
                            ) ?? data_get(
                                $other_universe,
                                'user_name'
                            ) ?? 'Unknown creator';
                        @endphp

                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white transition hover:border-indigo-200 hover:shadow-md">
                            <div class="flex flex-col lg:flex-row">
                                {{-- Logo --}}
                                <div class="relative h-48 bg-gray-100 lg:h-auto lg:w-64 lg:shrink-0">
                                    @if($otherUniverseLogo)
                                        <img
                                            src="{{ Storage::disk('s3-public')->url($otherUniverseLogo) }}"
                                            alt="{{ $otherUniverseName }} logo"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full min-h-48 w-full items-center justify-center bg-gradient-to-br from-purple-50 via-white to-indigo-50">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-14 w-14 text-purple-300"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a9.004 9.004 0 0 1 7.843 4.582M12 3a9.004 9.004 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"
                                                />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute left-4 top-4">
                                        @if($otherUniverseIsActive)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700 shadow-sm ring-1 ring-inset ring-green-600/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 shadow-sm ring-1 ring-inset ring-amber-600/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                Unpublished
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Information --}}
                                <div class="flex min-w-0 flex-1 flex-col justify-between p-5 sm:p-6">
                                    <div>
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                            <div class="min-w-0">
                                                <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                                                    Creator Universe
                                                </p>

                                                <h3 class="mt-2 truncate text-xl font-bold tracking-tight text-gray-900">
                                                    {{ $otherUniverseName }}
                                                </h3>

                                                <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                                                    <span>
                                                        Creator:
                                                        <strong class="font-semibold text-gray-700">
                                                            {{ $otherUniverseCreator }}
                                                        </strong>
                                                    </span>

                                                    @if($otherUniverseSlug)
                                                        <span>
                                                            Slug:
                                                            <strong class="font-semibold text-gray-700">
                                                                {{ $otherUniverseSlug }}
                                                            </strong>
                                                        </span>
                                                    @endif

                                                    <span>
                                                        ID:
                                                        <strong class="font-semibold text-gray-700">
                                                            #{{ $otherUniverseId }}
                                                        </strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($otherUniverseDescription)
                                            <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600">
                                                {{ $otherUniverseDescription }}
                                            </p>
                                        @else
                                            <p class="mt-4 text-sm italic text-gray-400">
                                                No universe description has been provided.
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div class="mt-6 flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                                        <a
                                            href="{{ route('universe.show', $otherUniverseId) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-4 w-4"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                />
                                            </svg>

                                            View Universe
                                        </a>
                                        <input type="hidden" id="{{ $other_universe->universe_slug_name }}" value="{{ $other_universe->id }}">
                                        @if($otherUniverseIsActive)

                                                <button
                                                    type="submit"
                                                     onclick="publishAction('unpublish', '{{ $other_universe->universe_slug_name }}')"
                                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="h-4 w-4"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M3 3l18 18M10.477 10.477A3 3 0 0 0 13.523 13.523M9.88 4.24A9.744 9.744 0 0 1 12 4.01c6 0 9.75 7 9.75 7a15.59 15.59 0 0 1-2.01 2.99M6.61 6.61C3.85 8.39 2.25 11 2.25 11s3.75 7 9.75 7a9.77 9.77 0 0 0 4.11-.9"
                                                        />
                                                    </svg>

                                                    Unpublish
                                                </button>
                                        @else
                                                <button
                                                    type="submit"
                                                     onclick="publishAction('publish', '{{ $other_universe->universe_slug_name }}')"
                                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="h-4 w-4"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 4.5v15m7.5-7.5h-15"
                                                        />
                                                    </svg>

                                                    Publish
                                                </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-7 w-7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198A11.944 11.944 0 0 1 12 21c-2.17 0-4.205-.576-5.963-1.584M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                            />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-gray-900">
                        No external universes found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Universes belonging to other creators will appear here for moderation.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>