<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Contest Center</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                    {{ auth()->user()->current_team_id == 2 ? 'All Contest Submissions' : 'My Contest Submissions' }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ auth()->user()->current_team_id == 2
                        ? 'Review every submitted contest entry from creators.'
                        : 'Track your contest entries, submission status, and uploaded pages.' }}
                </p>
            </div>

            @if(Route::has('contestant.create'))
                <a href="{{ route('contestant.create',$contest_submission_event_id) }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700">
                    New Submission
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-600 font-black text-white">✓</div>
                        <div>
                            <h3 class="text-sm font-black text-green-900">Submission received</h3>
                            <p class="mt-1 text-sm leading-6 text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">Total</p>
                    <p class="mt-3 text-3xl font-black text-gray-950">{{ $submissions->count() }}</p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">Submitted</p>
                    <p class="mt-3 text-3xl font-black text-indigo-600">
                        {{ $submissions->where('submission_status', \App\Models\ContestSubmission::STATUS_SUBMITTED)->count() }}
                    </p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500">Drafts</p>
                    <p class="mt-3 text-3xl font-black text-amber-600">
                        {{ $submissions->where('submission_status', \App\Models\ContestSubmission::STATUS_DRAFT)->count() }}
                    </p>
                </div>
            </div>

            @if($submissions->isEmpty())
                <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.75A3.75 3.75 0 0 0 10.875 3H8.25m2.625 0H5.625A1.125 1.125 0 0 0 4.5 4.125v15.75A1.125 1.125 0 0 0 5.625 21h12.75a1.125 1.125 0 0 0 1.125-1.125V11.625a3.375 3.375 0 0 0-3.375-3.375h-5.25V3Z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-black text-gray-950">No submissions yet</h3>
                    <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-600">
                        {{ auth()->user()->current_team_id == 2
                            ? 'Contest submissions will appear here after creators submit their entries.'
                            : 'Start a contest submission and it will appear here as a draft until you submit it.' }}
                    </p>
                </div>
            @else
                <div class="grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($submissions->sortByDesc('created_at') as $submission)
                        @php
                            $status = $submission->submission_status;
                            $statusClasses = match ($status) {
                                \App\Models\ContestSubmission::STATUS_SUBMITTED => 'bg-indigo-100 text-indigo-700',
                                \App\Models\ContestSubmission::STATUS_DRAFT => 'bg-amber-100 text-amber-700',
                                default => 'bg-gray-100 text-gray-700',
                            };

                            $pageCount = $submission->files
                                ->where('file_type', \App\Models\ContestSubmissionFile::TYPE_IMAGE)
                                ->count();
                        @endphp

                        <article class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative aspect-video overflow-hidden bg-gray-100">
                                @if($submission->primaryThumbnail)
                                    <img src="{{ Storage::disk('s3-public')->url($submission->primaryThumbnail->file_path) }}"
                                         alt="{{ $submission->submission_title }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-14 w-14 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="absolute left-4 top-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-black uppercase tracking-[0.15em] {{ $statusClasses }}">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                </div>

                                <div class="absolute bottom-4 right-4 rounded-full bg-black/75 px-3 py-1 text-xs font-black text-white backdrop-blur">
                                    {{ $pageCount }} {{ \Illuminate\Support\Str::plural('Page', $pageCount) }}
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                                            {{ $submission->submission_category ?? 'Contest Entry' }}
                                        </p>
                                        <h3 class="mt-2 line-clamp-2 text-xl font-black leading-tight text-gray-950">
                                            {{ $submission->submission_title }}
                                        </h3>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-gray-100 px-3 py-1 text-xs font-black text-gray-600">#{{ $submission->id }}</span>
                                </div>

                                @if(auth()->user()->current_team_id == 2)
                                    <p class="mt-4 text-sm font-bold text-gray-700">
                                        Submitted by:
                                        <span class="font-black text-gray-950">{{ optional($submission->user)->name ?? 'Unknown User' }}</span>
                                    </p>
                                @endif

                                <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600">
                                    {{ $submission->submission_description }}
                                </p>

                                <dl class="mt-6 grid grid-cols-2 gap-4 border-t border-gray-100 pt-5">
                                    <div>
                                        <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Universe</dt>
                                        <dd class="mt-1 truncate text-sm font-bold text-gray-800">
                                            {{ optional($submission->universe)->universe_name ?? 'Not assigned' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-black uppercase tracking-wider text-gray-400">Submitted</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-800">
                                            {{ $submission->submitted_at
                                                ? \Illuminate\Support\Carbon::parse($submission->submitted_at)->format('M j, Y')
                                                : 'Not submitted' }}
                                        </dd>
                                    </div>
                                </dl>

                                <div class="mt-6 flex flex-wrap gap-3">
                                    @if(Route::has('contestant.show') )
                                        <a href="{{ route('contestant.show', $submission) }}"
                                           class="inline-flex flex-1 items-center justify-center rounded-2xl bg-gray-950 px-4 py-3 text-sm font-black text-white transition hover:bg-gray-800">
                                            View Submission
                                        </a>
                                    @endif


                                    @if($submission->submission_status === \App\Models\ContestSubmission::STATUS_DRAFT
                                        && (int) $submission->user_id === (int) auth()->id()
                                        && Route::has('contestant.edit')
                                        && (auth()->user()->current_team_id = 2 
                                        || auth()->user()->id == $submission->user_id )
                                        )
                                        <a href="{{ route('contestant.edit', $submission) }}"
                                           class="inline-flex flex-1 items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-black text-gray-800 transition hover:bg-gray-50">
                                            Continue Draft
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
