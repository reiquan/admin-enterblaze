<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('polls.index') }}" class="font-medium transition hover:text-indigo-600">Polls</a>
                    <span>/</span>
                    <span>Edit</span>
                </div>

                <h2 class="mt-1 text-2xl font-bold leading-tight text-gray-900">Edit Poll</h2>
                <p class="mt-1 text-sm text-gray-500">Update poll details, options, voting rules, and schedule.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('polls.show', $poll) }}"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                    View Poll
                </a>

                <a href="{{ route('polls.index') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
                    Back to Polls
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $oldOptions = old('options');

        if ($oldOptions === null) {
            $oldOptions = $poll->options->map(function ($option) {
                return [
                    'id' => $option->id,
                    'name' => $option->name,
                    'description' => $option->description,
                    'image' => $option->image,
                ];
            })->values()->toArray();
        }

        if (count($oldOptions) < 2) {
            $oldOptions = array_pad($oldOptions, 2, [
                'id' => null,
                'name' => '',
                'description' => '',
                'image' => '',
            ]);
        }
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <h3 class="font-bold text-red-800">Please correct the following errors:</h3>
                    <ul class="mt-3 px-4 py-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('polls.update', $poll) }}" id="poll-edit-form">
                @csrf
          

                <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="space-y-8">
                        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-6 py-5">
                                <h3 class="text-lg font-bold text-gray-900">Poll Details</h3>
                                <p class="mt-1 text-sm text-gray-500">Update the question and supporting description.</p>
                            </div>

                            <div class="space-y-6 p-6">
                                <div>
                                    <div class="flex items-center justify-between gap-4">
                                        <label for="question" class="block text-sm font-semibold text-gray-900">Poll question</label>
                                        <span class="text-xs font-medium text-gray-400"><span data-question-count>0</span>/255</span>
                                    </div>

                                    <input type="text" name="question" id="question" maxlength="255"
                                           value="{{ old('question', $poll->question) }}"
                                           class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                           required>

                                    @error('question')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-900">Description</label>
                                    <textarea name="description" id="description" rows="5"
                                              class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $poll->description) }}</textarea>

                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Poll Options</h3>
                                    <p class="mt-1 text-sm text-gray-500">Edit, remove, or add answer choices.</p>
                                </div>

                                <button type="button" data-add-option
                                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                    Add Option
                                </button>
                            </div>

                            <div class="space-y-5 p-6" data-options-container>
                                @foreach($oldOptions as $index => $option)
                                    <article class="rounded-2xl border border-gray-200 bg-gray-50 p-5" data-option-row>
                                        <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option['id'] ?? '' }}" data-option-id>

                                        <div class="flex items-center justify-between gap-4">
                                            <p class="text-xs font-bold uppercase tracking-wide text-indigo-600">
                                                Option <span data-option-number>{{ $index + 1 }}</span>
                                            </p>

                                            <button type="button" data-remove-option
                                                    class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                                Remove
                                            </button>
                                        </div>

                                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-semibold text-gray-900">Option name</label>
                                                <input type="text" name="options[{{ $index }}][name]"
                                                       value="{{ $option['name'] ?? '' }}"
                                                       class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                       data-option-name required>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-semibold text-gray-900">Description</label>
                                                <textarea name="options[{{ $index }}][description]" rows="3"
                                                          class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                          data-option-description>{{ $option['description'] ?? '' }}</textarea>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-semibold text-gray-900">Image URL</label>
                                                <input type="text" name="options[{{ $index }}][image]"
                                                       value="{{ $option['image'] ?? '' }}"
                                                       class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                       data-option-image>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>

                        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-6 py-5">
                                <h3 class="text-lg font-bold text-gray-900">Voting Rules</h3>
                            </div>

                            <div class="grid gap-6 p-6 md:grid-cols-2">
                                <div>
                                    <label for="selection_type" class="block text-sm font-semibold text-gray-900">Selection type</label>
                                    <select name="selection_type" id="selection_type"
                                            class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="single" @selected(old('selection_type', $poll->selection_type) === 'single')>Single choice</option>
                                        <option value="multiple" @selected(old('selection_type', $poll->selection_type) === 'multiple')>Multiple choice</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="maximum_selections" class="block text-sm font-semibold text-gray-900">Maximum selections</label>
                                    <input type="number" name="maximum_selections" id="maximum_selections" min="1" max="20"
                                           value="{{ old('maximum_selections', $poll->maximum_selections ?? 1) }}"
                                           class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <label class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <input type="checkbox" name="allow_guests" value="1"
                                           class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           @checked(old('allow_guests', $poll->allow_guests))>
                                    <span class="text-sm font-semibold text-gray-900">Allow guest voting</span>
                                </label>

                                <label class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <input type="checkbox" name="show_results_before_voting" value="1"
                                           class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           @checked(old('show_results_before_voting', $poll->show_results_before_voting))>
                                    <span class="text-sm font-semibold text-gray-900">Show results before voting</span>
                                </label>

                                <label class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                                    <input type="checkbox" name="show_results_after_voting" value="1"
                                           class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           @checked(old('show_results_after_voting', $poll->show_results_after_voting))>
                                    <span class="text-sm font-semibold text-gray-900">Show results after voting</span>
                                </label>
                            </div>
                        </section>

                        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-6 py-5">
                                <h3 class="text-lg font-bold text-gray-900">Schedule</h3>
                            </div>

                            <div class="grid gap-6 p-6 md:grid-cols-2">
                                <div>
                                    <label for="starts_at" class="block text-sm font-semibold text-gray-900">Start date and time</label>
                                    <input type="datetime-local" name="starts_at" id="starts_at"
                                           value="{{ old('starts_at', optional($poll->starts_at)->format('Y-m-d\TH:i')) }}"
                                           class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="ends_at" class="block text-sm font-semibold text-gray-900">End date and time</label>
                                    <input type="datetime-local" name="ends_at" id="ends_at"
                                           value="{{ old('ends_at', optional($poll->ends_at)->format('Y-m-d\TH:i')) }}"
                                           class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <p class="hidden text-sm text-red-600 md:col-span-2" data-schedule-error>
                                    The end date must be after the start date.
                                </p>
                            </div>
                        </section>
                    </div>

                    <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-5 py-4">
                                <h3 class="font-bold text-gray-900">Publish Settings</h3>
                            </div>

                            <div class="space-y-5 p-5">
                                <label class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <input type="checkbox" name="is_published" value="1"
                                           class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           data-published-checkbox
                                           @checked(old('is_published', $poll->is_published))>
                                    <span class="text-sm font-semibold text-gray-900">Publish this poll</span>
                                </label>

                                <div class="rounded-xl bg-gray-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Current status</p>
                                    <p class="mt-2 text-sm font-bold text-gray-900" data-status-preview>Draft</p>
                                </div>

                                <button type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60"
                                        data-submit-button>
                                    <svg class="hidden h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" data-submit-spinner>
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"></path>
                                    </svg>
                                    <span data-submit-text>Update Poll</span>
                                </button>

                                <a href="{{ route('polls.show', $poll) }}"
                                   class="inline-flex w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                    Cancel
                                </a>
                            </div>
                        </section>
                    </aside>
                </div>
            </form>
        </div>
    </div>

    <template id="poll-option-template">
        <article class="rounded-2xl border border-gray-200 bg-gray-50 p-5" data-option-row>
            <input type="hidden" name="" value="" data-option-id>

            <div class="flex items-center justify-between gap-4">
                <p class="text-xs font-bold uppercase tracking-wide text-indigo-600">Option <span data-option-number></span></p>
                <button type="button" data-remove-option class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">Remove</button>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900">Option name</label>
                    <input type="text" name="" class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" data-option-name required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900">Description</label>
                    <textarea name="" rows="3" class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" data-option-description></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900">Image URL</label>
                    <input type="text" name="" class="mt-3 px-4 py-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" data-option-image>
                </div>
            </div>
        </article>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('poll-edit-form');
            if (!form || form.dataset.javascriptReady === 'true') return;
            form.dataset.javascriptReady = 'true';

            const optionsContainer = document.querySelector('[data-options-container]');
            const addOptionButton = document.querySelector('[data-add-option]');
            const optionTemplate = document.getElementById('poll-option-template');
            const selectionType = document.getElementById('selection_type');
            const maximumSelections = document.getElementById('maximum_selections');
            const question = document.getElementById('question');
            const questionCount = document.querySelector('[data-question-count]');
            const startsAt = document.getElementById('starts_at');
            const endsAt = document.getElementById('ends_at');
            const scheduleError = document.querySelector('[data-schedule-error]');
            const publishedCheckbox = document.querySelector('[data-published-checkbox]');
            const statusPreview = document.querySelector('[data-status-preview]');
            const submitButton = document.querySelector('[data-submit-button]');
            const submitSpinner = document.querySelector('[data-submit-spinner]');
            const submitText = document.querySelector('[data-submit-text]');

            const updateOptionIndexes = () => {
                const rows = optionsContainer.querySelectorAll('[data-option-row]');

                rows.forEach((row, index) => {
                    row.querySelector('[data-option-number]').textContent = index + 1;
                    row.querySelector('[data-option-id]').name = `options[${index}][id]`;
                    row.querySelector('[data-option-name]').name = `options[${index}][name]`;
                    row.querySelector('[data-option-description]').name = `options[${index}][description]`;
                    row.querySelector('[data-option-image]').name = `options[${index}][image]`;
                });

                optionsContainer.querySelectorAll('[data-remove-option]').forEach(button => {
                    button.disabled = rows.length <= 2;
                    button.classList.toggle('opacity-40', rows.length <= 2);
                    button.classList.toggle('cursor-not-allowed', rows.length <= 2);
                });

                maximumSelections.max = Math.max(rows.length, 1);
                if (Number(maximumSelections.value) > rows.length) maximumSelections.value = rows.length;
            };

            const updateSelectionRules = () => {
                const isMultiple = selectionType.value === 'multiple';
                maximumSelections.readOnly = !isMultiple;
                maximumSelections.classList.toggle('bg-gray-100', !isMultiple);
                maximumSelections.classList.toggle('text-gray-500', !isMultiple);
                if (!isMultiple) maximumSelections.value = 1;
            };

            const scheduleIsValid = () => {
                if (!startsAt.value || !endsAt.value) {
                    scheduleError.classList.add('hidden');
                    return true;
                }

                const valid = new Date(endsAt.value) > new Date(startsAt.value);
                scheduleError.classList.toggle('hidden', valid);
                return valid;
            };

            const updateStatusPreview = () => {
                if (!publishedCheckbox.checked) {
                    statusPreview.textContent = 'Draft';
                    return;
                }

                const now = new Date();
                const start = startsAt.value ? new Date(startsAt.value) : null;
                const end = endsAt.value ? new Date(endsAt.value) : null;

                if (end && end < now) statusPreview.textContent = 'Ended';
                else if (start && start > now) statusPreview.textContent = 'Scheduled';
                else statusPreview.textContent = 'Active';
            };

            addOptionButton.addEventListener('click', () => {
                if (optionsContainer.querySelectorAll('[data-option-row]').length >= 20) return;
                const fragment = optionTemplate.content.cloneNode(true);
                optionsContainer.appendChild(fragment);
                updateOptionIndexes();
                optionsContainer.lastElementChild.querySelector('[data-option-name]').focus();
            });

            optionsContainer.addEventListener('click', event => {
                const removeButton = event.target.closest('[data-remove-option]');
                if (!removeButton) return;
                if (optionsContainer.querySelectorAll('[data-option-row]').length <= 2) return;
                removeButton.closest('[data-option-row]').remove();
                updateOptionIndexes();
            });

            selectionType.addEventListener('change', updateSelectionRules);
            question.addEventListener('input', () => questionCount.textContent = question.value.length);
            startsAt.addEventListener('change', () => { scheduleIsValid(); updateStatusPreview(); });
            endsAt.addEventListener('change', () => { scheduleIsValid(); updateStatusPreview(); });
            publishedCheckbox.addEventListener('change', updateStatusPreview);

            form.addEventListener('submit', event => {
                if (!scheduleIsValid()) {
                    event.preventDefault();
                    endsAt.focus();
                    return;
                }

                submitButton.disabled = true;
                submitSpinner.classList.remove('hidden');
                submitText.textContent = 'Updating...';
            });

            questionCount.textContent = question.value.length;
            updateOptionIndexes();
            updateSelectionRules();
            updateStatusPreview();
        });
    </script>
</x-app-layout>
