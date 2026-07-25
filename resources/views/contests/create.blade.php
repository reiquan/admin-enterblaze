<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Contest Entry</p>
                <h2 class="mt-1 text-xl font-black leading-tight text-gray-900">{{ __('Create Contest Submission') }}</h2>
            </div>

            @isset($event)
                <div class="inline-flex w-fit items-center rounded-full bg-amber-50 px-4 py-2 text-xs font-bold text-amber-700 ring-1 ring-amber-200">
                    {{ $event->event_name ?? 'Contest' }}
                </div>
            @endisset
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    <div class="relative isolate p-8 sm:p-10">
                        <div class="absolute right-0 top-0 -z-10 h-40 w-40 rounded-full bg-indigo-100 blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -z-10 h-32 w-32 rounded-full bg-amber-100 blur-3xl"></div>

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.35em] text-indigo-600">Enterblaze Contest Portal</p>
                                <h1 class="mt-4 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">Submit Your Contest Entry</h1>
                                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                    Start with the core information for your entry. You can continue through the remaining contest steps after this information has been saved.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <span class="inline-flex items-center rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-2 text-sm font-bold text-indigo-700">
                                    Step {{ $step ?? 1 }} of 4
                                </span>

                                @isset($event)
                                    <span class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm">
                                        Contest #{{ $event->id }}
                                    </span>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @php
                        $progressSteps = [
                            1 => ['Submission Details', 'Title, category, description'],
                            2 => ['Contest Requirements', 'Complete the required entry fields'],
                            3 => ['Review', 'Confirm your submission'],
                            4 => ['Submit', 'Finalize your contest entry'],
                        ];
                    @endphp

                    @foreach($progressSteps as $progressStep => [$label, $description])
                        <div class="rounded-3xl border {{ ($step ?? 1) >= $progressStep ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200 bg-white' }} p-5 shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ ($step ?? 1) >= $progressStep ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-black">
                                    {{ $progressStep }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-950">{{ $label }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($step !== 1)
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm lg:p-8">
                        @include('components.contests.contestant-uploader.contestant-form-step-'.$step)
                    </div>
                @else
                    <form method="POST" action="{{ route('contestant.store') }}" class="space-y-8">
                        @csrf

                        <input type="hidden" name="step" value="1">
                        <input type="hidden" name="submission_status" value="draft">
                        

                        @isset($event)
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        @endisset

                        @if($errors->any())
                            <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                                <div class="flex gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-red-100 font-black text-red-700">!</div>
                                    <div>
                                        <h3 class="text-sm font-black text-red-900">Please fix the following before continuing:</h3>
                                        <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-100 p-6 sm:p-8">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Step 1</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-gray-950">Submission Information</h2>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                                    Give the judges a clear overview of your entry. File uploads are intentionally handled in a later step.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-8 p-6 sm:p-8 lg:grid-cols-3">
                                <div class="lg:col-span-2">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <label for="submission_title" class="block text-sm font-bold text-gray-900">Submission Title</label>
                                            <input
                                                type="text"
                                                name="submission_title"
                                                id="submission_title"
                                                value="{{ old('submission_title', $contest_submission->submission_title ?? '') }}"
                                                maxlength="255"
                                                required
                                                placeholder="Example: The Last Guardian of Osun"
                                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                            @error('submission_title')
                                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="submission_category" class="block text-sm font-bold text-gray-900">Submission Category</label>
                                            <select
                                                name="submission_category"
                                                id="submission_category"
                                                required
                                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                                <option value="">Select a category</option>
                                                @foreach(($contest_categories ?? []) as $category)
                                                    @php
                                                        $categoryValue = is_object($category)
                                                            ? ($category->name ?? $category->title ?? $category->id)
                                                            : $category;
                                                    @endphp
                                                    <option value="{{ $categoryValue }}" @selected(old('submission_category', $contest_submission->submission_category ?? '') == $categoryValue)>
                                                        {{ $categoryValue }}
                                                    </option>
                                                @endforeach

                                                @if(empty($contest_categories))
                                                    <option value="Manga" @selected(old('submission_category') === 'Manga')>Manga</option>
                                                    <option value="Comic" @selected(old('submission_category') === 'Comic')>Comic</option>
                                                    <option value="Erotic" @selected(old('submission_category') === 'Erotic')>Erotic</option>
                                                    <option value="Other" @selected(old('submission_category') === 'Other')>Other</option>
                                                @endif
                                            </select>
                                            @error('submission_category')
                                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- <div>
                                            <label for="universe_id" class="block text-sm font-bold text-gray-900">Related Universe</label>
                                            <select
                                                name="universe_id"
                                                id="universe_id"
                                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                                <option value="">No related universe</option>
                                                @foreach(($universes ?? []) as $universe)
                                                    <option value="{{ $universe->id }}" @selected((string) old('universe_id', $contest_submission->universe_id ?? '') === (string) $universe->id)>
                                                        {{ $universe->universe_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('universe_id')
                                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div> -->

                                        <div class="sm:col-span-2">
                                            <label for="submission_description" class="block text-sm font-bold text-gray-900">Entry Description</label>
                                            <textarea
                                                name="submission_description"
                                                id="submission_description"
                                                rows="8"
                                                required
                                                placeholder="Describe your entry, its concept, its inspiration, and why it fits this contest."
                                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >{{ old('submission_description', $contest_submission->submission_description ?? '') }}</textarea>
                                            <p class="mt-2 text-xs leading-5 text-gray-500">
                                                Explain the creative idea clearly enough for judges to understand the entry before reviewing its submitted materials.
                                            </p>
                                            @error('submission_description')
                                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="submission_url" class="block text-sm font-bold text-gray-900">
                                                Supporting Link <span class="font-medium text-gray-400">(optional)</span>
                                            </label>
                                            <input
                                                type="url"
                                                name="submission_url"
                                                id="submission_url"
                                                value="{{ old('submission_url', $contest_submission->submission_url ?? '') }}"
                                                placeholder="https://example.com/portfolio-or-project"
                                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            >
                                            <p class="mt-2 text-xs text-gray-500">Add a portfolio, website, published project, or other relevant public link.</p>
                                            @error('submission_url')
                                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <aside class="space-y-6">
                                    <div class="rounded-3xl border border-gray-200 bg-gray-50 p-6">
                                        <h3 class="text-sm font-black text-gray-950">Contest</h3>

                                        @isset($event)
                                            <p class="mt-3 text-lg font-black text-gray-950">{{ $event->event_name }}</p>

                                            @if(!empty($event->event_description))
                                                <p class="mt-2 line-clamp-5 text-sm leading-6 text-gray-600">{{ $event->event_description }}</p>
                                            @endif

                                            @if(!empty($event->event_end_date))
                                                <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4">
                                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-700">Deadline</p>
                                                    <p class="mt-1 text-sm font-bold text-amber-950">
                                                        {{ \Illuminate\Support\Carbon::parse($event->event_end_date)->format('M j, Y g:i A') }}
                                                    </p>
                                                </div>
                                            @endif
                                        @else
                                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                                Contest information will appear here when an event is supplied to this view.
                                            </p>
                                        @endisset
                                    </div>

                                    <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                                        <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Submission Tip</p>
                                        <p class="mt-3 text-sm leading-6 text-indigo-950">
                                            Use a recognizable title and a focused description. Judges should be able to understand what makes your entry special before opening any supporting materials.
                                        </p>
                                    </div>
                                </aside>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-100 p-6 sm:p-8">
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Confirmations</p>
                                <h2 class="mt-3 text-xl font-black tracking-tight text-gray-950">Contest Rules and Permissions</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-600">These confirmations are required before the submission can continue.</p>
                            </div>

                            <div class="space-y-5 p-6 sm:p-8">
                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-200 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/30">
                                    <input
                                        type="checkbox"
                                        name="rules_accepted"
                                        value="1"
                                        @checked(old('rules_accepted', $contest_submission->rules_accepted ?? false))
                                        required
                                        class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <span>
                                        <span class="block text-sm font-bold text-gray-900">I accept the contest rules.</span>
                                        <span class="mt-1 block text-xs leading-5 text-gray-500">I have reviewed the contest requirements, eligibility rules, deadlines, and judging terms.</span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-200 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/30">
                                    <input
                                        type="checkbox"
                                        name="original_work_confirmed"
                                        value="1"
                                        @checked(old('original_work_confirmed', $contest_submission->original_work_confirmed ?? false))
                                        required
                                        class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <span>
                                        <span class="block text-sm font-bold text-gray-900">I confirm that this is original work.</span>
                                        <span class="mt-1 block text-xs leading-5 text-gray-500">I own the submitted work or have permission from every rights holder required to enter it.</span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-200 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/30">
                                    <input
                                        type="checkbox"
                                        name="public_display_permission"
                                        value="1"
                                        @checked(old('public_display_permission', $contest_submission->public_display_permission ?? false))
                                        required
                                        class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <span>
                                        <span class="block text-sm font-bold text-gray-900">I grant permission for contest display.</span>
                                        <span class="mt-1 block text-xs leading-5 text-gray-500">Enterblaze may display this entry on contest pages, promotional materials, livestreams, and winner announcements.</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-50">
                                Cancel
                            </a>

                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save & Continue
                                <span class="ml-2">→</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
