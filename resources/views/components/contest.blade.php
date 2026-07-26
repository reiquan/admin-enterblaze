@if(isset($contests))
    @foreach($contests as $event)
        <div
            id="contest-banner"
            class="relative overflow-hidden border-b border-amber-300 bg-gradient-to-r from-amber-500 via-yellow-400 to-orange-500 px-6 py-5 text-gray-950 shadow-lg lg:px-8"
        >
            <div class="pointer-events-none absolute inset-0 opacity-20">
                <div class="absolute -left-10 -top-16 h-40 w-40 rounded-full bg-white blur-3xl"></div>
                <div class="absolute right-10 top-0 h-32 w-32 rounded-full bg-red-500 blur-3xl"></div>
            </div>

            <div class="relative mx-auto flex max-w-7xl flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-black/10 ring-1 ring-black/10">
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
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.75m-5.25 4.5v-3.375c0-.621.504-1.125 1.125-1.125h.75m3.375 0h-3.75m3.75 0a4.125 4.125 0 0 0 4.125-4.125V4.875A1.125 1.125 0 0 0 17.625 3.75h-11.25A1.125 1.125 0 0 0 5.25 4.875v5.25a4.125 4.125 0 0 0 4.125 4.125m5.25 0h-5.25M5.25 6.75H3.375A1.125 1.125 0 0 0 2.25 7.875v1.5a3.375 3.375 0 0 0 3.375 3.375M18.75 6.75h1.875a1.125 1.125 0 0 1 1.125 1.125v1.5a3.375 3.375 0 0 1-3.375 3.375"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-red-950/70">
                            Contest Event
                        </p>

                        <h2 class="mt-1 text-xl font-black tracking-tight sm:text-2xl">
                            {{ $event->event_name ?? 'A new contest is now open!' }}
                        </h2>

                        <p class="mt-1 max-w-2xl text-sm font-medium text-gray-900/80">
                            Compete for prizes, recognition, and a chance to be featured by Enterblaze.
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3">
            
                        <a
                            href="{{ route('contestant.create', $event->id) }}"
                            class="inline-flex items-center justify-center rounded-xl bg-gray-950 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-gray-800"
                        >
                            Enter Contest
                        </a>
                        @if(auth()->user()->current_team_id == 2)
                        <a
                            href="{{ route('contestant.index', $event->id ) }}"
                            class="inline-flex items-center justify-center rounded-xl bg-orange-800 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-gray-800"
                        >
                            Manage Entries
                        </a>
                        @endif
     

                    <button
                        type="button"
                        onclick="document.getElementById('contest-banner').remove()"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-black/10 transition hover:bg-black/20"
                        aria-label="Dismiss contest banner"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@endif