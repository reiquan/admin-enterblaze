
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a
                        href="{{ route('polls.index') }}"
                        class="font-medium transition hover:text-indigo-600"
                    >
                        Polls
                    </a>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>

                    <span>View</span>
                </div>

                <h2 class="mt-1 text-2xl font-bold leading-tight text-gray-900">
                    Poll Details
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Review the poll, its options, schedule, and current voting results.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a
                    href="{{ route('polls.edit', $poll) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13l-2.685.805.805-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Zm0 0L19.5 7.125" />
                    </svg>

                    Edit Poll
                </a>

                <a
                    href="{{ route('polls.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>

                    Back to Polls
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $totalVotes = (int) ($poll->votes_count ?? $poll->votes?->count() ?? 0);

        $status = 'Draft';
        $statusClasses = 'bg-gray-100 text-gray-700 ring-gray-200';
        $statusDot = 'bg-gray-400';

        if ($poll->is_published) {
            if ($poll->ends_at && $poll->ends_at->isPast()) {
                $status = 'Ended';
                $statusClasses = 'bg-red-50 text-red-700 ring-red-200';
                $statusDot = 'bg-red-500';
            } elseif ($poll->starts_at && $poll->starts_at->isFuture()) {
                $status = 'Scheduled';
                $statusClasses = 'bg-blue-50 text-blue-700 ring-blue-200';
                $statusDot = 'bg-blue-500';
            } else {
                $status = 'Active';
                $statusClasses = 'bg-green-50 text-green-700 ring-green-200';
                $statusDot = 'bg-green-500';
            }
        }
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800">
                    <div class="flex items-start gap-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mt-0.5 h-5 w-5 flex-none"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>

                        <p class="font-semibold">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
                <div class="space-y-8">
                    {{-- Main Poll Card --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset {{ $statusClasses }}">
                                            <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>
                                            {{ $status }}
                                        </span>

                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                            {{ $poll->selection_type === 'multiple' ? 'Multiple choice' : 'Single choice' }}
                                        </span>
                                    </div>

                                    <h1 class="mt-4 text-2xl font-black leading-tight text-gray-900 sm:text-3xl">
                                        {{ $poll->question }}
                                    </h1>

                                    @if($poll->description)
                                        <p class="mt-4 whitespace-pre-line text-sm leading-7 text-gray-600">
                                            {{ $poll->description }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-none items-center gap-3 rounded-xl bg-gray-50 px-4 py-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white text-indigo-600 shadow-sm">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-5 w-5"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75h-1.5m-9 0V2.25m9 1.5V2.25m-9 1.5h9m-9 0A2.25 2.25 0 0 0 9.75 6h4.5a2.25 2.25 0 0 0 2.25-2.25" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                            Total Votes
                                        </p>
                                        <p class="text-xl font-black text-gray-900">
                                            {{ number_format($totalVotes) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 p-6 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Options
                                </p>
                                <p class="mt-2 text-2xl font-black text-gray-900">
                                    {{ $poll->options->count() }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Max selections
                                </p>
                                <p class="mt-2 text-2xl font-black text-gray-900">
                                    {{ $poll->maximum_selections }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Guest voting
                                </p>
                                <p class="mt-2 text-lg font-black {{ $poll->allow_guests ? 'text-green-600' : 'text-gray-700' }}">
                                    {{ $poll->allow_guests ? 'Allowed' : 'Disabled' }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Created
                                </p>
                                <p class="mt-2 text-sm font-bold text-gray-900">
                                    {{ optional($poll->created_at)->format('M j, Y') ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Poll Results --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-6 w-6"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125C16.5 3.504 17.004 3 17.625 3h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        Poll Results
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Vote totals and percentage share for each option.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5 p-6">
                            @forelse($poll->options as $option)
                                @php
                                    $optionVotes = (int) ($option->votes_count ?? $option->votes?->count() ?? 0);
                                    $percentage = $totalVotes > 0
                                        ? round(($optionVotes / $totalVotes) * 100, 1)
                                        : 0;
                                @endphp

                                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                                    <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center">
                                        @if($option->image)
                                            <img
                                                src="{{ $option->image }}"
                                                alt="{{ $option->name }}"
                                                class="h-24 w-full rounded-xl object-cover sm:h-20 sm:w-20"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="flex h-20 w-20 flex-none items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="h-7 w-7"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A1.5 1.5 0 0 0 21.75 18V6A1.5 1.5 0 0 0 20.25 4.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z" />
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                                <div>
                                                    <h4 class="font-bold text-gray-900">
                                                        {{ $option->name }}
                                                    </h4>

                                                    @if($option->description)
                                                        <p class="mt-1 text-sm leading-6 text-gray-500">
                                                            {{ $option->description }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="flex-none text-left sm:text-right">
                                                    <p class="text-lg font-black text-gray-900">
                                                        {{ $percentage }}%
                                                    </p>

                                                    <p class="text-xs font-semibold text-gray-500">
                                                        {{ number_format($optionVotes) }}
                                                        {{ \Illuminate\Support\Str::plural('vote', $optionVotes) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-4 h-3 overflow-hidden rounded-full bg-gray-100">
                                                <div
                                                    class="h-full rounded-full bg-indigo-600 transition-all duration-500"
                                                    style="width: {{ min($percentage, 100) }}%"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="mx-auto h-10 w-10 text-gray-400"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3.75 6H4.5v.75h-.75V6Zm0 6h.75v.75h-.75V12Zm0 6h.75v.75h-.75V18Z" />
                                    </svg>

                                    <h4 class="mt-4 font-bold text-gray-900">
                                        No poll options found
                                    </h4>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Edit this poll and add at least two options.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-5 py-4">
                            <h3 class="font-bold text-gray-900">
                                Poll Settings
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Current visibility and voting configuration.
                            </p>
                        </div>

                        <dl class="divide-y divide-gray-100 px-5">
                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-sm text-gray-500">Published</dt>
                                <dd class="text-sm font-bold {{ $poll->is_published ? 'text-green-600' : 'text-gray-700' }}">
                                    {{ $poll->is_published ? 'Yes' : 'No' }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-sm text-gray-500">Voting type</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $poll->selection_type === 'multiple' ? 'Multiple choice' : 'Single choice' }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-sm text-gray-500">Guest voting</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $poll->allow_guests ? 'Allowed' : 'Disabled' }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-sm text-gray-500">Results before vote</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $poll->show_results_before_voting ? 'Visible' : 'Hidden' }}
                                </dd>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-4">
                                <dt class="text-sm text-gray-500">Results after vote</dt>
                                <dd class="text-sm font-bold text-gray-900">
                                    {{ $poll->show_results_after_voting ? 'Visible' : 'Hidden' }}
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-5 py-4">
                            <h3 class="font-bold text-gray-900">
                                Schedule
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Poll availability window.
                            </p>
                        </div>

                        <div class="space-y-5 p-5">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Starts
                                </p>

                                <p class="mt-2 text-sm font-semibold text-gray-900">
                                    {{ $poll->starts_at ? $poll->starts_at->format('M j, Y \a\t g:i A') : 'Immediately' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                    Ends
                                </p>

                                <p class="mt-2 text-sm font-semibold text-gray-900">
                                    {{ $poll->ends_at ? $poll->ends_at->format('M j, Y \a\t g:i A') : 'No end date' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">
                        <div class="border-b border-red-100 px-5 py-4">
                            <h3 class="font-bold text-red-700">
                                Danger Zone
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Permanently remove this poll and its data.
                            </p>
                        </div>

                        <div class="p-5">
                            <button
                                type="button"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                data-open-delete-modal
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                                Delete Poll
                            </button>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div
        class="fixed inset-0 z-50 hidden"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-poll-title"
        data-delete-modal
    >
        <div class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm" data-delete-backdrop></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 id="delete-poll-title" class="text-lg font-bold text-gray-900">
                                Delete poll?
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                This will permanently delete
                                <span class="font-semibold text-gray-900">“{{ $poll->question }}”</span>,
                                along with its options and recorded votes.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        data-close-delete-modal
                    >
                        Cancel
                    </button>

                    <form method="POST" action="{{ route('polls.destroy', $poll) }}" data-delete-form>
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500 disabled:cursor-not-allowed disabled:opacity-60"
                            data-delete-submit
                        >
                            <svg
                                class="hidden h-4 w-4 animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                data-delete-spinner
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"></path>
                            </svg>

                            <span data-delete-text>Delete Poll</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-delete-modal]');
            const openButton = document.querySelector('[data-open-delete-modal]');
            const closeButton = document.querySelector('[data-close-delete-modal]');
            const backdrop = document.querySelector('[data-delete-backdrop]');
            const deleteForm = document.querySelector('[data-delete-form]');
            const deleteSubmit = document.querySelector('[data-delete-submit]');
            const deleteSpinner = document.querySelector('[data-delete-spinner]');
            const deleteText = document.querySelector('[data-delete-text]');

            if (!modal || !openButton) {
                return;
            }

            const openModal = () => {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                closeButton?.focus();
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                openButton.focus();
            };

            openButton.addEventListener('click', openModal);
            closeButton?.addEventListener('click', closeModal);
            backdrop?.addEventListener('click', closeModal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            deleteForm?.addEventListener('submit', () => {
                if (deleteSubmit) {
                    deleteSubmit.disabled = true;
                }

                deleteSpinner?.classList.remove('hidden');

                if (deleteText) {
                    deleteText.textContent = 'Deleting...';
                }
            });
        });
    </script>

