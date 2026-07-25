<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Contest Submission</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                    {{ $contest_submission->submission_title }}
                </h2>
            </div>

            <a href="{{ route('contestant.index', $contest_submission->event_id) }}"
               class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-50">
                Back to Submissions
            </a>
        </div>
    </x-slot>

    @php
        $status = $contest_submission->submission_status;

        $statusClasses = match ($status) {
            \App\Models\ContestSubmission::STATUS_SUBMITTED => 'bg-indigo-100 text-indigo-700',
            \App\Models\ContestSubmission::STATUS_DRAFT => 'bg-amber-100 text-amber-700',
            defined('\\App\\Models\\ContestSubmission::STATUS_APPROVED')
                && $status === \App\Models\ContestSubmission::STATUS_APPROVED
                => 'bg-green-100 text-green-700',
            defined('\\App\\Models\\ContestSubmission::STATUS_REJECTED')
                && $status === \App\Models\ContestSubmission::STATUS_REJECTED
                => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };

        $pages = $contest_submission->files
            ->where('file_type', \App\Models\ContestSubmissionFile::TYPE_IMAGE)
            ->sortBy('sort_order');

        $canManage = (int) auth()->user()->current_team_id === 2
            || (int) $contest_submission->user_id === (int) auth()->id();
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-3xl border border-green-200 bg-green-50 p-6 shadow-sm">
                    <p class="font-black text-green-900">Success</p>
                    <p class="mt-1 text-sm text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
                <main class="space-y-8">
                    <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                        <div class="relative aspect-video overflow-hidden bg-gray-100">
                            @if($contest_submission->primaryThumbnail)
                                <img
                                    src="{{ Storage::disk('s3-public')->url($contest_submission->primaryThumbnail->file_path) }}"
                                    alt="{{ $contest_submission->submission_title }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full items-center justify-center bg-gray-100 text-sm font-black text-gray-400">
                                    No thumbnail uploaded
                                </div>
                            @endif

                            <div class="absolute left-5 top-5">
                                <span class="rounded-full px-4 py-2 text-xs font-black uppercase tracking-[0.15em] {{ $statusClasses }}">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                                {{ $contest_submission->submission_category ?? 'Contest Entry' }}
                            </p>

                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                {{ $contest_submission->submission_title }}
                            </h1>

                            <p class="mt-3 text-sm font-bold text-gray-600">
                                Submitted by
                                <span class="text-gray-950">
                                    {{ optional($contest_submission->user)->name ?? 'Unknown User' }}
                                </span>
                            </p>
                        </div>
                    </section>

                    <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">About This Entry</p>
                        <h2 class="mt-3 text-2xl font-black text-gray-950">Submission Description</h2>

                        <div class="mt-5 rounded-2xl bg-gray-50 p-5 text-sm leading-7 text-gray-700">
                            {!! nl2br(e($contest_submission->submission_description)) !!}
                        </div>

                        @if($contest_submission->submission_url)
                            <a
                                href="{{ $contest_submission->submission_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-6 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white transition hover:bg-indigo-700"
                            >
                                Open External Link
                            </a>
                        @endif
                    </section>

                    <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Submission Assets</p>
                                <h2 class="mt-3 text-2xl font-black text-gray-950">Uploaded Pages</h2>
                            </div>

                            <span class="rounded-full bg-indigo-100 px-4 py-2 text-xs font-black text-indigo-700">
                                {{ $pages->count() }} {{ \Illuminate\Support\Str::plural('Page', $pages->count()) }}
                            </span>
                        </div>

                        @if($pages->isEmpty())
                            <div class="mt-6 rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                                <p class="text-sm font-bold text-gray-500">No submission pages were uploaded.</p>
                            </div>
                        @else
                            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($pages as $page)
                                    <a
                                        href="{{ Storage::disk('s3-public')->url($page->file_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                                    >
                                        <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                                            <img
                                                src="{{ Storage::disk('s3-public')->url($page->file_path) }}"
                                                alt="Page {{ $page->sort_order }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            >

                                            <div class="absolute left-3 top-3 rounded-full bg-black/80 px-3 py-1 text-xs font-black text-white">
                                                Page {{ $page->sort_order }}
                                            </div>
                                        </div>

                                        <div class="p-4">
                                            <p class="truncate text-sm font-black text-gray-900">{{ $page->file_name }}</p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ number_format($page->file_size / 1024 / 1024, 2) }} MB
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </main>

                <aside class="space-y-6">
                    <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Submission Details</p>

                        <dl class="mt-6 space-y-5">
                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Creator</dt>
                                <dd class="mt-1 text-sm font-black text-gray-900">
                                    {{ optional($contest_submission->user)->name ?? 'Unknown User' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Universe</dt>
                                <dd class="mt-1 text-sm font-black text-gray-900">
                                    {{ optional($contest_submission->universe)->universe_name ?? 'Not assigned' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Submitted</dt>
                                <dd class="mt-1 text-sm font-black text-gray-900">
                                    {{ $contest_submission->submitted_at
                                        ? \Illuminate\Support\Carbon::parse($contest_submission->submitted_at)->format('M j, Y g:i A')
                                        : 'Not submitted' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Pages</dt>
                                <dd class="mt-1 text-sm font-black text-gray-900">{{ $pages->count() }} / 5</dd>
                            </div>
                        </dl>
                    </section>

                    @if($canManage)
                        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Manage Submission</p>

                            <div class="mt-5 space-y-3">
                                @if(
                                    $contest_submission->submission_status !== \App\Models\ContestSubmission::STATUS_DRAFT
                                    && Route::has('contestant.unpublish')
                                )
                                    <form method="POST" action="{{ route('contestant.unpublish', $contest_submission) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Move this submission back to draft status?');"
                                            class="inline-flex w-full items-center justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white transition hover:bg-amber-600"
                                        >
                                            Unpublish Submission
                                        </button>
                                    </form>
                                @endif

                                @if(
                                    $contest_submission->submission_status === \App\Models\ContestSubmission::STATUS_DRAFT
                                    && Route::has('contestant.edit')
                                )
                                    <a
                                        href="{{ route('contestant.edit', $contest_submission) }}"
                                        class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-800 transition hover:bg-gray-50"
                                    >
                                        Continue Editing
                                    </a>
                                @endif
                            </div>
                        </section>

                        <section class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.25em] text-red-600">Danger Zone</p>
                            <h3 class="mt-3 text-lg font-black text-red-950">Delete Submission</h3>
                            <p class="mt-2 text-sm leading-6 text-red-800">
                                This removes the submission and all uploaded files. This action cannot be undone.
                            </p>

                            @if(Route::has('contestant.destroy'))
                                <form method="POST" action="{{ route('contestant.destroy',[$contest_submission->event_id, $contest_submission]) }}" class="mt-5">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Delete this submission and all uploaded files?');"
                                        class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white transition hover:bg-red-700"
                                    >
                                        Delete Submission
                                    </button>
                                </form>
                            @endif
                        </section>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
