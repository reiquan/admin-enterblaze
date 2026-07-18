<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <div class="flex items-center justify-between gap-4">
        <x-application-logo class="block h-12 w-auto" />

        <div class="hidden sm:flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-red-100">
            Creator Admin Suite
        </div>
    </div>

    <div class="mt-8 max-w-3xl">
        <h1 class="text-2xl font-medium text-gray-900 sm:text-3xl">
            Don&rsquo;t wait for opportunity.
            <span class="font-bold text-red-800">Make one.</span>
        </h1>

        <p class="mt-4 text-gray-600 leading-relaxed">
            Build and manage the pieces behind your book&rsquo;s success from one clean dashboard. Create your universe,
            organize events, manage digital products, and prepare your story for readers around the world.
        </p>
    </div>

    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
        <a href="{{ route('universe.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            Open My Universe
        </a>

        @if(auth()->check() && auth()->user()->current_team_id == 2)
            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2">
                Manage Events
            </a>
        @endif
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('universe.index') }}" class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-800 ring-1 ring-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </div>

                <h2 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-red-800">
                    My Universe
                </h2>
            </div>

            <p class="mt-4 text-sm leading-relaxed text-gray-500">
                Organize your worlds, books, characters, settings, and lore in one structured creative workspace.
            </p>

            <div class="mt-5 text-sm font-semibold text-red-800">
                Manage universe &rarr;
            </div>
        </a>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-700 ring-1 ring-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <h2 class="ml-4 text-lg font-semibold text-gray-900">
                    Production Flow
                </h2>
            </div>

            <p class="mt-4 text-sm leading-relaxed text-gray-500">
                Keep your publishing pipeline simple: create the book, build the shop, package the EPUB, and launch.
            </p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50 text-gray-700 ring-1 ring-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5A1.125 1.125 0 0 1 9.375 10.5h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5ZM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5Z" />
                    </svg>
                </div>

                <h2 class="ml-4 text-lg font-semibold text-gray-900">
                    Shop Tools
                </h2>
            </div>

            <p class="mt-4 text-sm leading-relaxed text-gray-500">
                Prepare products, bundles, digital downloads, and launch assets without cluttering the dashboard.
            </p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->current_team_id == 2)
        <div class="mt-8 border-t border-gray-200 pt-8">
            <div class="mb-5 flex items-end justify-between gap-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Team tools</h3>
                    <p class="mt-1 text-sm text-gray-500">Quick access for this team workspace.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <a href="{{ route('events.index') }}" class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-800 ring-1 ring-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>

                        <h2 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-red-800">
                            Events
                        </h2>
                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-gray-500">
                        Manage events, schedules, guests, vendors, and related event content.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-red-800">
                        Manage events &rarr;
                    </div>
                </a>

                <a href="{{ route('tokens.tiers.index') }}" class="group rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-red-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-800 ring-1 ring-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" />
                            </svg>
                        </div>

                        <h2 class="ml-4 text-lg font-semibold text-gray-900 group-hover:text-red-800">
                            Blaze Tokens
                        </h2>
                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-gray-500">
                        Configure token tiers, access levels, and purchase options for your platform.
                    </p>

                    <div class="mt-5 text-sm font-semibold text-red-800">
                        Manage tokens &rarr;
                    </div>
                </a>
            </div>
        </div>
    @endif
</div>
