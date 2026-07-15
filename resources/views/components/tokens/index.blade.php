<div class="min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-8">

        {{-- Page Header --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="relative p-8 sm:p-10">
                <div class="absolute inset-x-0 top-0 h-1 bg-indigo-600"></div>

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                            Blaze Tokens
                        </p>

                        <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                            Token Tier Manager
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                            Create, price, publish, and manage Blaze Token bundles for your Enterblaze store and member rewards system.
                        </p>
                    </div>

                    <a href="{{ route('tokens.tiers.create') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        Create Tier
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-gray-500">Total Tiers</p>
                <p class="mt-3 text-4xl font-black text-gray-950">{{ isset($tiers) ? $tiers->count() : 0 }}</p>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-gray-500">Published</p>
                <p class="mt-3 text-4xl font-black text-green-600">{{ isset($tiers) ? $tiers->where('token_tier_is_active', true)->count() : 0 }}</p>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-gray-500">Drafts</p>
                <p class="mt-3 text-4xl font-black text-orange-500">{{ isset($tiers) ? $tiers->where('token_tier_is_active', false)->count() : 0 }}</p>
            </div>
        </div>

        {{-- Create Card --}}
        <a href="{{ route('tokens.tiers.create') }}"
           class="group block rounded-3xl border-2 border-dashed border-gray-300 bg-white p-10 text-center shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 transition group-hover:bg-indigo-600 group-hover:text-white">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
            </div>

            <h2 class="mt-5 text-lg font-black text-gray-950">Create a New Token Tier</h2>
            <p class="mt-2 text-sm text-gray-500">Build a Blaze Token package with a token amount, USD price, and publish status.</p>
        </a>

        {{-- Tier Cards --}}
        @if(isset($tiers) && $tiers->count())
            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($tiers as $tier)
                    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">
                                        Tier #{{ $tier->id }}
                                    </p>

                                    <h3 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                                        {{ $tier->token_tier_name }}
                                    </h3>
                                </div>

                                @if($tier->token_tier_is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1.5 text-xs font-black uppercase tracking-widest text-green-700">
                                        Published
                                    </span>
                                @else
                                    <span class="rounded-full bg-orange-100 px-3 py-1.5 text-xs font-black uppercase tracking-widest text-orange-700">
                                        Draft
                                    </span>
                                @endif
                            </div>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-gray-50 p-4 ring-1 ring-gray-100">
                                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Blaze Tokens</p>
                                    <p class="mt-2 text-2xl font-black text-gray-950">
                                        {{ number_format($tier->token_tier_amount) }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-gray-50 p-4 ring-1 ring-gray-100">
                                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">USD Price</p>
                                    <p class="mt-2 text-2xl font-black text-gray-950">
                                        ${{ number_format($tier->token_tier_usd_price, 2) }}
                                    </p>
                                </div>
                            </div>

                            <input type="hidden" id="{{ $tier->id }}" value="{{ $tier->id }}">
                        </div>

                        <div class="grid grid-cols-3 divide-x divide-gray-200 border-t border-gray-200 bg-gray-50">
                            <div class="p-3">
                                @if($tier->token_tier_is_active)
                                    <button id="unpublish{{ $tier->id }}"
                                            type="button"
                                            onclick="publishAction('unpublish', '{{ $tier->id }}')"
                                            class="w-full rounded-2xl bg-yellow-100 px-4 py-3 text-sm font-black text-yellow-800 transition hover:bg-yellow-200">
                                        Unpublish
                                    </button>
                                @else
                                    <button id="publish{{ $tier->id }}"
                                            type="button"
                                            onclick="publishAction('publish', '{{ $tier->id }}')"
                                            class="w-full rounded-2xl bg-green-100 px-4 py-3 text-sm font-black text-green-800 transition hover:bg-green-200">
                                        Publish
                                    </button>
                                @endif
                            </div>

                            <div class="p-3">
                                <form action="{{ route('tokens.tiers.edit', ['tier_id' => $tier->id]) }}" method="GET">
                                    <input type="hidden" id="tier_id{{ $tier->id }}" name="tier_id" value="{{ $tier->id }}">
                                    <button type="submit"
                                            class="w-full rounded-2xl bg-indigo-50 px-4 py-3 text-sm font-black text-indigo-700 transition hover:bg-indigo-100">
                                        Edit
                                    </button>
                                </form>
                            </div>

                            <div class="p-3">
                                <button type="button"
                                        onclick="confirmDelete('{{ $tier->id }}')"
                                        class="w-full rounded-2xl bg-red-50 px-4 py-3 text-sm font-black text-red-700 transition hover:bg-red-100">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-gray-200 bg-white p-12 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-500">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 1-2.25 2.25H16.5a2.25 2.25 0 0 0-2.25 2.25v2.25A2.25 2.25 0 0 1 12 21m0 0a9 9 0 1 1 9-9m-9 9a9 9 0 0 1-9-9" />
                    </svg>
                </div>

                <h2 class="mt-5 text-2xl font-black text-gray-950">No Token Tiers Created</h2>
                <p class="mt-2 text-sm text-gray-500">Create your first Blaze Token tier to start selling token packages.</p>

                <a href="{{ route('tokens.tiers.create') }}"
                   class="mt-6 inline-flex rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700">
                    Create Tier
                </a>
            </div>
        @endif
    </div>
</div>
