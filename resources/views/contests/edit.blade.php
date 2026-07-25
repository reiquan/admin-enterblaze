<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                    Contest Submission
                </p>

                <h2 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                    Edit {{ $contest_submission->submission_title }}
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Continue your submission using the same step files from the creation wizard.
                </p>
            </div>

            <a
                href="{{ route('contestant.show', $contest_submission) }}"
                class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                View Submission
            </a>
        </div>
    </x-slot>

    @php
        $currentStep = (int) ($step ?? 1);
        $totalSteps = 4;

        $stepLabels = [
            1 => 'Entry Details',
            2 => 'Thumbnail',
            3 => 'Submission Pages',
            4 => 'Confirmation',
        ];

        $progress = max(0, min(100, (($currentStep - 1) / ($totalSteps - 1)) * 100));
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-600 font-black text-white">
                            ✓
                        </div>

                        <div>
                            <h3 class="text-sm font-black text-green-900">
                                Changes saved
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid gap-8 xl:grid-cols-[300px_minmax(0,1fr)]">

                <aside class="space-y-6">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                            Submission Progress
                        </p>

                        <div class="mt-5">
                            <div class="flex items-center justify-between text-xs font-black text-gray-500">
                                <span>Step {{ $currentStep }} of {{ $totalSteps }}</span>
                                <span>{{ (int) round($progress) }}%</span>
                            </div>

                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-100">
                                <div
                                    class="h-full rounded-full bg-indigo-600 transition-all duration-300"
                                    style="width: {{ $progress }}%;"
                                ></div>
                            </div>
                        </div>

                        <nav class="mt-6 space-y-3">
                            @foreach($stepLabels as $stepNumber => $label)
                                @php
                                    $isCurrent = $currentStep === $stepNumber;
                                    $isComplete = $currentStep > $stepNumber;
                                @endphp

                                <div
                                    class="flex items-center gap-3 rounded-2xl border px-4 py-3
                                        {{ $isCurrent
                                            ? 'border-indigo-200 bg-indigo-50'
                                            : 'border-gray-200 bg-white' }}"
                                >
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-black
                                            {{ $isComplete
                                                ? 'bg-green-600 text-white'
                                                : ($isCurrent
                                                    ? 'bg-indigo-600 text-white'
                                                    : 'bg-gray-100 text-gray-500') }}"
                                    >
                                        {{ $isComplete ? '✓' : $stepNumber }}
                                    </div>

                                    <div>
                                        <p class="text-xs font-black uppercase tracking-wider text-gray-400">
                                            Step {{ $stepNumber }}
                                        </p>

                                        <p class="mt-1 text-sm font-black text-gray-900">
                                            {{ $label }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </nav>
                    </div>

                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                            Submission Status
                        </p>

                        <div class="mt-4">
                            <span class="inline-flex rounded-full bg-gray-100 px-4 py-2 text-xs font-black uppercase tracking-[0.15em] text-gray-700">
                                {{ str_replace('_', ' ', $contest_submission->submission_status) }}
                            </span>
                        </div>

                        <dl class="mt-5 space-y-4">
                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">
                                    Title
                                </dt>

                                <dd class="mt-1 text-sm font-black text-gray-900">
                                    {{ $contest_submission->submission_title }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-gray-400">
                                    Last Updated
                                </dt>

                                <dd class="mt-1 text-sm font-bold text-gray-700">
                                    {{ optional($contest_submission->updated_at)->format('M j, Y g:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </aside>

                <main>
                    @if($currentStep >= 1 && $currentStep <= 4)
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm lg:p-8">
                            @include(
                                'components.contests.contestant-uploader.contestant-form-step-' . $currentStep
                            )
                        </div>
                    @else
                        <div class="rounded-3xl border border-red-200 bg-red-50 p-8 text-center shadow-sm">
                            <h3 class="text-lg font-black text-red-900">
                                Invalid submission step
                            </h3>

                            <p class="mt-2 text-sm text-red-700">
                                The requested step could not be found.
                            </p>

                            <a
                                href="{{ route('contestant.edit', ['contest_submission' => $contest_submission, 'step' => 1]) }}"
                                class="mt-5 inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white transition hover:bg-red-700"
                            >
                                Return to Step 1
                            </a>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
