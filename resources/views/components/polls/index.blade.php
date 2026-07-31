
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-gray-900">
                    Polls
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Create community polls, manage voting periods, and review audience participation.
                </p>
            </div>

            <a
                href="{{ route('polls.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Create Poll
            </a>
        </div>
    </x-slot>


    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div
                    class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 flex-none"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                    <p class="font-medium">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mt-0.5 h-5 w-5 flex-none"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                        />
                    </svg>

                    <p class="font-medium">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            {{-- Statistics --}}
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Total Polls
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $polls->count() }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-indigo-50 p-3 text-indigo-600">
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
                                    d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3.75 6H4.5v.75h-.75V6Zm0 6h.75v.75h-.75V12Zm0 6h.75v.75h-.75V18Z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Published
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $publishedPollCount ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-green-50 p-3 text-green-600">
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
                                    d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Active Now
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $activePollCount ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
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
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Total Votes
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ number_format($totalVoteCount ?? 0) }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
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
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM19.5 7.125 16.875 4.5M18 14.25v4.125c0 1.036-.84 1.875-1.875 1.875H5.625A1.875 1.875 0 0 1 3.75 18.375V7.875C3.75 6.84 4.59 6 5.625 6H9.75"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search and Filters --}}
            <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <form
                    method="GET"
                    action="{{ route('polls.index') }}"
                    class="grid gap-4 lg:grid-cols-[1fr_200px_200px_auto]"
                >
                    <div>
                        <label
                            for="search"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Search polls
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 text-gray-400"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                                    />
                                </svg>
                            </div>

                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="Search by poll question..."
                                autocomplete="off"
                                class="block w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                data-poll-search
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            for="status"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="block w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            data-poll-filter
                        >
                            <option value="">All statuses</option>
                            <option
                                value="active"
                                @selected(request('status') === 'active')
                            >
                                Active
                            </option>
                            <option
                                value="scheduled"
                                @selected(request('status') === 'scheduled')
                            >
                                Scheduled
                            </option>
                            <option
                                value="ended"
                                @selected(request('status') === 'ended')
                            >
                                Ended
                            </option>
                            <option
                                value="draft"
                                @selected(request('status') === 'draft')
                            >
                                Draft
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="selection_type"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Selection type
                        </label>

                        <select
                            name="selection_type"
                            id="selection_type"
                            class="block w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            data-poll-filter
                        >
                            <option value="">All types</option>
                            <option
                                value="single"
                                @selected(request('selection_type') === 'single')
                            >
                                Single choice
                            </option>
                            <option
                                value="multiple"
                                @selected(request('selection_type') === 'multiple')
                            >
                                Multiple choice
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                    <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60"
                            data-filter-submit
                        >
                            <svg
                                class="hidden h-4 w-4 animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                data-button-spinner
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                                ></path>
                            </svg>

                            <span data-button-text>Filter</span>
                        </button>

                        @if(
                            request()->filled('search')
                            || request()->filled('status')
                            || request()->filled('selection_type')
                        )
                        <a
                            href="{{ route('polls.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            title="Clear filters"
                            data-clear-filters
                        >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18 18 6M6 6l12 12"
                                    />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Poll List --}}
            <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                All Polls
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Manage your Enterblaze community polls.
                            </p>
                        </div>

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                            {{ $polls->count() }}
                            {{ Str::plural('poll', $polls->count()) }}
                        </span>
                    </div>
                </div>

                @if($polls->count())
                    {{-- Desktop Table --}}
                    <div class="hidden overflow-x-auto lg:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Poll
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Status
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Options
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Votes
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Schedule
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($polls as $poll)
                                    @php
                                        $isScheduled = $poll->is_published
                                            && $poll->starts_at
                                            && $poll->starts_at->isFuture();

                                        $isEnded = $poll->ends_at
                                            && $poll->ends_at->isPast();

                                        $isActive = $poll->is_published
                                            && ! $isScheduled
                                            && ! $isEnded;

                                        $statusLabel = 'Draft';
                                        $statusClasses = 'bg-gray-100 text-gray-700';

                                        if ($isScheduled) {
                                            $statusLabel = 'Scheduled';
                                            $statusClasses = 'bg-blue-100 text-blue-700';
                                        } elseif ($isEnded) {
                                            $statusLabel = 'Ended';
                                            $statusClasses = 'bg-red-100 text-red-700';
                                        } elseif ($isActive) {
                                            $statusLabel = 'Active';
                                            $statusClasses = 'bg-green-100 text-green-700';
                                        }
                                    @endphp

                                    <tr class="transition hover:bg-gray-50">
                                        <td class="px-6 py-5">
                                            <div class="max-w-md">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $poll->question }}
                                                    </p>

                                                    @if($poll->allow_guests)
                                                        <span
                                                            class="rounded-full bg-purple-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-purple-700"
                                                        >
                                                            Guests
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($poll->description)
                                                    <p class="mt-1 line-clamp-2 text-sm text-gray-500">
                                                        {{ $poll->description }}
                                                    </p>
                                                @endif

                                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                                    <span>
                                                        Created {{ $poll->created_at->diffForHumans() }}
                                                    </span>

                                                    <span aria-hidden="true">•</span>

                                                    <span class="capitalize">
                                                        {{ $poll->selection_type }} choice
                                                    </span>

                                                    @if($poll->pollable)
                                                        <span aria-hidden="true">•</span>

                                                        <span>
                                                            {{ class_basename($poll->pollable_type) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <span
                                                class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}"
                                            >
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                            {{ $poll->options_count ?? $poll->options->count() }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-semibold text-gray-900">
                                                    {{ number_format($poll->votes_count ?? $poll->votes->count()) }}
                                                </span>

                                                <span class="text-xs text-gray-500">
                                                    votes
                                                </span>
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                            @if($poll->starts_at || $poll->ends_at)
                                                <div class="space-y-1">
                                                    @if($poll->starts_at)
                                                        <p>
                                                            <span class="font-medium text-gray-700">Starts:</span>
                                                            {{ $poll->starts_at->format('M j, Y g:i A') }}
                                                        </p>
                                                    @endif

                                                    @if($poll->ends_at)
                                                        <p>
                                                            <span class="font-medium text-gray-700">Ends:</span>
                                                            {{ $poll->ends_at->format('M j, Y g:i A') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400">
                                                    No schedule
                                                </span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a
                                                    href="{{ route('polls.show', $poll) }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white p-2 text-gray-600 transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600"
                                                    title="View poll"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="h-5 w-5"
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
                                                </a>

                                                <a
                                                    href="{{ route('polls.edit', $poll) }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white p-2 text-gray-600 transition hover:border-amber-300 hover:bg-amber-50 hover:text-amber-600"
                                                    title="Edit poll"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="h-5 w-5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM19.5 7.125 16.875 4.5M18 14.25v4.125c0 1.036-.84 1.875-1.875 1.875H5.625A1.875 1.875 0 0 1 3.75 18.375V7.875C3.75 6.84 4.59 6 5.625 6H9.75"
                                                        />
                                                    </svg>
                                                </a>
                                                <form
                                                    method="POST"
                                                    action="{{ route('polls.destroy', $poll) }}"
                                                    data-poll-delete-form
                                                    data-poll-question="{{ $poll->question }}"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white p-2 text-gray-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-50"
                                                        title="Delete poll"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="h-5 w-5"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                            />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="divide-y divide-gray-200 lg:hidden">
                        @foreach($polls as $poll)
                            @php
                                $isScheduled = $poll->is_published
                                    && $poll->starts_at
                                    && $poll->starts_at->isFuture();

                                $isEnded = $poll->ends_at
                                    && $poll->ends_at->isPast();

                                $isActive = $poll->is_published
                                    && ! $isScheduled
                                    && ! $isEnded;

                                $statusLabel = 'Draft';
                                $statusClasses = 'bg-gray-100 text-gray-700';

                                if ($isScheduled) {
                                    $statusLabel = 'Scheduled';
                                    $statusClasses = 'bg-blue-100 text-blue-700';
                                } elseif ($isEnded) {
                                    $statusLabel = 'Ended';
                                    $statusClasses = 'bg-red-100 text-red-700';
                                } elseif ($isActive) {
                                    $statusLabel = 'Active';
                                    $statusClasses = 'bg-green-100 text-green-700';
                                }
                            @endphp

                            <article class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <span
                                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}"
                                        >
                                            {{ $statusLabel }}
                                        </span>

                                        <h4 class="mt-3 text-base font-bold text-gray-900">
                                            {{ $poll->question }}
                                        </h4>

                                        @if($poll->description)
                                            <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                                {{ $poll->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <dl class="mt-5 grid grid-cols-2 gap-4 rounded-xl bg-gray-50 p-4">
                                    <div>
                                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                            Options
                                        </dt>

                                        <dd class="mt-1 text-sm font-bold text-gray-900">
                                            {{ $poll->options_count ?? $poll->options->count() }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                            Votes
                                        </dt>

                                        <dd class="mt-1 text-sm font-bold text-gray-900">
                                            {{ number_format($poll->votes_count ?? $poll->votes->count()) }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                            Type
                                        </dt>

                                        <dd class="mt-1 text-sm font-bold capitalize text-gray-900">
                                            {{ $poll->selection_type }}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                            Guest Voting
                                        </dt>

                                        <dd class="mt-1 text-sm font-bold text-gray-900">
                                            {{ $poll->allow_guests ? 'Enabled' : 'Disabled' }}
                                        </dd>
                                    </div>
                                </dl>

                                @if($poll->starts_at || $poll->ends_at)
                                    <div class="mt-4 space-y-1 text-sm text-gray-500">
                                        @if($poll->starts_at)
                                            <p>
                                                Starts {{ $poll->starts_at->format('M j, Y g:i A') }}
                                            </p>
                                        @endif

                                        @if($poll->ends_at)
                                            <p>
                                                Ends {{ $poll->ends_at->format('M j, Y g:i A') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <div class="mt-5 grid grid-cols-3 gap-2">
                                    <a
                                        href="{{ route('polls.show', $poll) }}"
                                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('polls.edit', $poll) }}"
                                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('polls.destroy', $poll) }}"
                                        data-poll-delete-form
                                        data-poll-question="{{ $poll->question }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($polls->hasPages())
                        <div class="border-t border-gray-200 px-6 py-4">
                            {{ $polls->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-8 w-8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3.75 6H4.5v.75h-.75V6Zm0 6h.75v.75h-.75V12Zm0 6h.75v.75h-.75V18Z"
                                />
                            </svg>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                            No polls found
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Create your first Enterblaze poll to collect community feedback,
                            character votes, contest selections, or release preferences.
                        </p>

                        <a
                            href="{{ route('polls.create') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4.5v15m7.5-7.5h-15"
                                />
                            </svg>

                            Create Your First Poll
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div
    class="fixed inset-0 z-50 hidden"
    role="dialog"
    aria-modal="true"
    aria-labelledby="delete-poll-title"
    data-delete-modal
>
    <div
        class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm"
        data-delete-modal-backdrop
    ></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div
            class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
            data-delete-modal-panel
        >
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full bg-red-100 text-red-600">
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
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3
                            id="delete-poll-title"
                            class="text-lg font-bold text-gray-900"
                        >
                            Delete poll?
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            You are about to delete
                            <span
                                class="font-semibold text-gray-900"
                                data-delete-poll-name
                            ></span>.
                            This will also remove its options and recorded votes.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                    data-delete-cancel
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500 disabled:cursor-not-allowed disabled:opacity-60"
                    data-delete-confirm
                >
                    <svg
                        class="hidden h-4 w-4 animate-spin"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        data-delete-spinner
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                        ></path>
                    </svg>

                    <span data-delete-button-text>
                        Delete Poll
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    initializePollFilters();
    initializePollDeleteModal();
    initializeFormLoadingStates();
});

function initializePollFilters() {
    const form = document.querySelector('[data-poll-filter-form]');

    if (!form) {
        return;
    }

    const searchInput = form.querySelector('[data-poll-search]');
    const filterInputs = form.querySelectorAll('[data-poll-filter]');
    const submitButton = form.querySelector('[data-filter-submit]');
    const clearButton = document.querySelector('[data-clear-filters]');

    let searchTimer = null;
    let isSubmitting = false;

    function submitFilters() {
        if (isSubmitting) {
            return;
        }

        isSubmitting = true;
        setFilterButtonLoading(submitButton, true);
        form.submit();
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            window.clearTimeout(searchTimer);

            searchTimer = window.setTimeout(() => {
                submitFilters();
            }, 500);
        });

        searchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                window.clearTimeout(searchTimer);
                submitFilters();
            }
        });
    }

    filterInputs.forEach((filter) => {
        filter.addEventListener('change', () => {
            window.clearTimeout(searchTimer);
            submitFilters();
        });
    });

    form.addEventListener('submit', () => {
        isSubmitting = true;
        setFilterButtonLoading(submitButton, true);
    });

    if (clearButton) {
        clearButton.addEventListener('click', (event) => {
            event.preventDefault();

            if (isSubmitting) {
                return;
            }

            isSubmitting = true;

            const destination = clearButton.getAttribute('href');

            if (destination) {
                window.location.assign(destination);
            }
        });
    }
}

function setFilterButtonLoading(button, isLoading) {
    if (!button) {
        return;
    }

    const spinner = button.querySelector('[data-button-spinner]');
    const text = button.querySelector('[data-button-text]');

    button.disabled = isLoading;

    if (spinner) {
        spinner.classList.toggle('hidden', !isLoading);
    }

    if (text) {
        text.textContent = isLoading ? 'Loading...' : 'Filter';
    }
}

function initializePollDeleteModal() {
    const modal = document.querySelector('[data-delete-modal]');
    const deleteForms = document.querySelectorAll('[data-poll-delete-form]');

    if (!modal || deleteForms.length === 0) {
        return;
    }

    const backdrop = modal.querySelector('[data-delete-modal-backdrop]');
    const modalPanel = modal.querySelector('[data-delete-modal-panel]');
    const pollName = modal.querySelector('[data-delete-poll-name]');
    const cancelButton = modal.querySelector('[data-delete-cancel]');
    const confirmButton = modal.querySelector('[data-delete-confirm]');
    const spinner = modal.querySelector('[data-delete-spinner]');
    const confirmButtonText = modal.querySelector(
        '[data-delete-button-text]'
    );

    let pendingDeleteForm = null;
    let previouslyFocusedElement = null;
    let isDeleting = false;

    deleteForms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (isDeleting) {
                return;
            }

            pendingDeleteForm = form;
            previouslyFocusedElement = document.activeElement;

            const question = form.dataset.pollQuestion || 'this poll';

            if (pollName) {
                pollName.textContent = `"${question}"`;
            }

            openModal();

            window.setTimeout(() => {
                cancelButton?.focus();
            }, 50);
        });
    });

    cancelButton?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);

    confirmButton?.addEventListener('click', () => {
        if (!pendingDeleteForm || isDeleting) {
            return;
        }

        isDeleting = true;
        confirmButton.disabled = true;
        cancelButton.disabled = true;

        spinner?.classList.remove('hidden');

        if (confirmButtonText) {
            confirmButtonText.textContent = 'Deleting...';
        }

        const originalDeleteButton = pendingDeleteForm.querySelector(
            'button[type="submit"]'
        );

        if (originalDeleteButton) {
            originalDeleteButton.disabled = true;
        }

        pendingDeleteForm.submit();
    });

    document.addEventListener('keydown', (event) => {
        if (modal.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape' && !isDeleting) {
            closeModal();
        }

        if (event.key === 'Tab') {
            trapFocus(event);
        }
    });

    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        if (isDeleting) {
            return;
        }

        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        pendingDeleteForm = null;

        if (previouslyFocusedElement instanceof HTMLElement) {
            previouslyFocusedElement.focus();
        }
    }

    function trapFocus(event) {
        if (!modalPanel) {
            return;
        }

        const focusableElements = modalPanel.querySelectorAll(
            [
                'button:not([disabled])',
                'a[href]',
                'input:not([disabled])',
                'select:not([disabled])',
                'textarea:not([disabled])',
                '[tabindex]:not([tabindex="-1"])',
            ].join(',')
        );

        if (focusableElements.length === 0) {
            return;
        }

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[
            focusableElements.length - 1
        ];

        if (
            event.shiftKey
            && document.activeElement === firstElement
        ) {
            event.preventDefault();
            lastElement.focus();
        } else if (
            !event.shiftKey
            && document.activeElement === lastElement
        ) {
            event.preventDefault();
            firstElement.focus();
        }
    }
}

function initializeFormLoadingStates() {
    const forms = document.querySelectorAll(
        'form:not([data-poll-filter-form]):not([data-poll-delete-form])'
    );

    forms.forEach((form) => {
        form.addEventListener('submit', () => {
            const submitButton = form.querySelector(
                'button[type="submit"]'
            );

            if (!submitButton || submitButton.disabled) {
                return;
            }

            submitButton.disabled = true;
        });
    });
}
</script>
@endpush
