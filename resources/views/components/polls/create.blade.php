<x-app-layout>
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

                    <span>Create</span>
                </div>

                <h2 class="mt-1 text-2xl font-bold leading-tight text-gray-900">
                    Create Poll
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Build a community poll for manga, characters, cards, events, contests, or future releases.
                </p>
            </div>

            <a
                href="{{ route('polls.index') }}"
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>

                Back to Polls
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800">
                    <div class="flex items-start gap-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mt-0.5 h-5 w-5 flex-none"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>

                        <div>
                            <p class="font-semibold">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('polls.store') }}"
                class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]"
                data-poll-create-form
            >
                @csrf

                <div class="space-y-8">
                    {{-- Poll Details --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-6 w-6"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 12h9.75m-9.75 6h9.75M3.75 6H4.5v.75h-.75V6Zm0 6h.75v.75h-.75V12Zm0 6h.75v.75h-.75V18Z" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        Poll Details
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Write the question and explain what the community is voting on.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 p-6">
                            <div>
                                <label for="question" class="block text-sm font-semibold text-gray-900">
                                    Poll question
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Example: Which character should receive the next limited-edition card?
                                </p>

                                <input
                                    type="text"
                                    name="question"
                                    id="question"
                                    value="{{ old('question') }}"
                                    maxlength="255"
                                    required
                                    autofocus
                                    placeholder="Enter the poll question"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('question') border-red-300 @enderror"
                                    data-poll-question
                                >

                                <div class="mt-2 flex items-center justify-between gap-4">
                                    @error('question')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @else
                                        <span></span>
                                    @enderror

                                    <p class="text-xs text-gray-400">
                                        <span data-question-count>0</span>/255
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-900">
                                    Description
                                    <span class="font-normal text-gray-400">(optional)</span>
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Add context, voting instructions, or information about how the results will be used.
                                </p>

                                <textarea
                                    name="description"
                                    id="description"
                                    rows="5"
                                    maxlength="5000"
                                    placeholder="Describe the poll..."
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror"
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    {{-- Poll Options --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">
                                            Poll Options
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Add at least two choices. You can include descriptions and image URLs.
                                        </p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100 disabled:cursor-not-allowed disabled:opacity-50"
                                    data-add-option
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-5 w-5"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>

                                    Add Option
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4" data-options-container>
                                @php
                                    $oldOptions = old('options', [
                                        ['name' => '', 'description' => '', 'image' => ''],
                                        ['name' => '', 'description' => '', 'image' => ''],
                                    ]);
                                @endphp

                                @foreach($oldOptions as $index => $option)
                                    <article
                                        class="rounded-2xl border border-gray-200 bg-gray-50 p-5"
                                        data-option-row
                                    >
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-sm font-bold text-gray-700 shadow-sm" data-option-number>
                                                    {{ $index + 1 }}
                                                </div>

                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        Poll option
                                                    </h4>

                                                    <p class="text-xs text-gray-500">
                                                        Choice shown to voters
                                                    </p>
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white p-2 text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40"
                                                title="Remove option"
                                                data-remove-option
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
                                            </button>
                                        </div>

                                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                                            <div class="lg:col-span-2">
                                                <label class="block text-sm font-semibold text-gray-800">
                                                    Option name
                                                </label>

                                                <input
                                                    type="text"
                                                    name="options[{{ $index }}][name]"
                                                    value="{{ $option['name'] ?? '' }}"
                                                    maxlength="255"
                                                    required
                                                    placeholder="Example: Na'Qir"
                                                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error("options.$index.name") border-red-300 @enderror"
                                                    data-option-name
                                                >

                                                @error("options.$index.name")
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-800">
                                                    Description
                                                    <span class="font-normal text-gray-400">(optional)</span>
                                                </label>

                                                <textarea
                                                    name="options[{{ $index }}][description]"
                                                    rows="3"
                                                    maxlength="1000"
                                                    placeholder="Add supporting details..."
                                                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error("options.$index.description") border-red-300 @enderror"
                                                >{{ $option['description'] ?? '' }}</textarea>

                                                @error("options.$index.description")
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-800">
                                                    Image URL
                                                    <span class="font-normal text-gray-400">(optional)</span>
                                                </label>

                                                <input
                                                    type="url"
                                                    name="options[{{ $index }}][image]"
                                                    value="{{ $option['image'] ?? '' }}"
                                                    maxlength="2048"
                                                    placeholder="https://..."
                                                    class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error("options.$index.image") border-red-300 @enderror"
                                                >

                                                @error("options.$index.image")
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <template data-option-template>
                                <article class="rounded-2xl border border-gray-200 bg-gray-50 p-5" data-option-row>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-sm font-bold text-gray-700 shadow-sm" data-option-number></div>

                                            <div>
                                                <h4 class="font-semibold text-gray-900">Poll option</h4>
                                                <p class="text-xs text-gray-500">Choice shown to voters</p>
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white p-2 text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40"
                                            title="Remove option"
                                            data-remove-option
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="mt-5 grid gap-4 lg:grid-cols-2">
                                        <div class="lg:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-800">Option name</label>
                                            <input type="text" maxlength="255" required placeholder="Example: Na'Qir" class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" data-field="name" data-option-name>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800">Description <span class="font-normal text-gray-400">(optional)</span></label>
                                            <textarea rows="3" maxlength="1000" placeholder="Add supporting details..." class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" data-field="description"></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800">Image URL <span class="font-normal text-gray-400">(optional)</span></label>
                                            <input type="url" maxlength="2048" placeholder="https://..." class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" data-field="image">
                                        </div>
                                    </div>
                                </article>
                            </template>

                            <div class="mt-5 flex items-center justify-between rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-500">
                                <span>
                                    <strong class="text-gray-700" data-option-count>{{ count($oldOptions) }}</strong>
                                    of 20 options added
                                </span>

                                <span>Minimum: 2</span>
                            </div>
                        </div>
                    </section>

                    {{-- Voting Rules --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v5.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 1-1.591.659H10.682a2.25 2.25 0 0 1-1.591-.659L3.659 11.41A2.25 2.25 0 0 1 3 9.818V4.774c0-.54.384-1.006.917-1.096A48.02 48.02 0 0 1 12 3Z" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Voting Rules</h3>
                                    <p class="mt-1 text-sm text-gray-500">Control how many choices voters can select and when results appear.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 p-6 lg:grid-cols-2">
                            <div>
                                <label for="selection_type" class="block text-sm font-semibold text-gray-900">
                                    Selection type
                                </label>

                                <select
                                    name="selection_type"
                                    id="selection_type"
                                    class="mt-3 block w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    data-selection-type
                                >
                                    <option value="single" @selected(old('selection_type', 'single') === 'single')>
                                        Single choice
                                    </option>
                                    <option value="multiple" @selected(old('selection_type') === 'multiple')>
                                        Multiple choice
                                    </option>
                                </select>

                                @error('selection_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="maximum_selections" class="block text-sm font-semibold text-gray-900">
                                    Maximum selections
                                </label>

                                <input
                                    type="number"
                                    name="maximum_selections"
                                    id="maximum_selections"
                                    value="{{ old('maximum_selections', 1) }}"
                                    min="1"
                                    max="20"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:text-gray-500"
                                    data-maximum-selections
                                >

                                <p class="mt-2 text-xs text-gray-500" data-selection-help>
                                    Single-choice polls are limited to one selection.
                                </p>

                                @error('maximum_selections')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                                <input
                                    type="hidden"
                                    name="allow_guests"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="allow_guests"
                                    value="1"
                                    @checked(old('allow_guests'))
                                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >

                                <span>
                                    <span class="block text-sm font-semibold text-gray-900">Allow guest voting</span>
                                    <span class="mt-1 block text-xs leading-5 text-gray-500">Visitors can vote without signing into an Enterblaze account.</span>
                                </span>
                            </label>

                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                                <input type="hidden" name="show_results_before_voting" value="0">
                                <input
                                    type="checkbox"
                                    name="show_results_before_voting"
                                    value="1"
                                    @checked(old('show_results_before_voting'))
                                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >

                                <span>
                                    <span class="block text-sm font-semibold text-gray-900">Show results before voting</span>
                                    <span class="mt-1 block text-xs leading-5 text-gray-500">Voters can see current percentages before making a selection.</span>
                                </span>
                            </label>

                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50 lg:col-span-2">
                                <input type="hidden" name="show_results_after_voting" value="0">
                                <input
                                    type="checkbox"
                                    name="show_results_after_voting"
                                    value="1"
                                    @checked(old('show_results_after_voting', true))
                                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >

                                <span>
                                    <span class="block text-sm font-semibold text-gray-900">Show results after voting</span>
                                    <span class="mt-1 block text-xs leading-5 text-gray-500">Display totals and percentages after the voter submits their response.</span>
                                </span>
                            </label>
                        </div>
                    </section>

                    {{-- Schedule --}}
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5m-16.5 0A2.25 2.25 0 0 1 6 7.5h12a2.25 2.25 0 0 1 2.25 2.25m-16.5 0v8.25A2.25 2.25 0 0 0 6 20.25h12a2.25 2.25 0 0 0 2.25-2.25V9.75" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Poll Schedule</h3>
                                    <p class="mt-1 text-sm text-gray-500">Leave either field blank when the poll should start immediately or remain open indefinitely.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 p-6 lg:grid-cols-2">
                            <div>
                                <label for="starts_at" class="block text-sm font-semibold text-gray-900">
                                    Starts at
                                    <span class="font-normal text-gray-400">(optional)</span>
                                </label>

                                <input
                                    type="datetime-local"
                                    name="starts_at"
                                    id="starts_at"
                                    value="{{ old('starts_at') }}"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('starts_at') border-red-300 @enderror"
                                    data-starts-at
                                >

                                @error('starts_at')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ends_at" class="block text-sm font-semibold text-gray-900">
                                    Ends at
                                    <span class="font-normal text-gray-400">(optional)</span>
                                </label>

                                <input
                                    type="datetime-local"
                                    name="ends_at"
                                    id="ends_at"
                                    value="{{ old('ends_at') }}"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('ends_at') border-red-300 @enderror"
                                    data-ends-at
                                >

                                <p class="mt-2 hidden text-sm text-red-600" data-schedule-error></p>

                                @error('ends_at')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-200 px-5 py-4">
                            <h3 class="font-bold text-gray-900">Publish Settings</h3>
                            <p class="mt-1 text-xs text-gray-500">Choose whether this poll is available to the public.</p>
                        </div>

                        <div class="space-y-5 p-5">
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                                <input type="hidden" name="is_published" value="0">
                                <input
                                    type="checkbox"
                                    name="is_published"
                                    value="1"
                                    @checked(old('is_published'))
                                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    data-publish-toggle
                                >

                                <span>
                                    <span class="block text-sm font-semibold text-gray-900">Publish poll</span>
                                    <span class="mt-1 block text-xs leading-5 text-gray-500">The poll becomes visible when its schedule allows it.</span>
                                </span>
                            </label>

                            <div class="rounded-xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Current status</p>

                                <div class="mt-3 flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-gray-400" data-status-dot></span>
                                    <span class="text-sm font-semibold text-gray-700" data-status-label>Draft</span>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
                                data-submit-button
                            >
                                <svg
                                    class="hidden h-4 w-4 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    data-submit-spinner
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"></path>
                                </svg>

                                <span data-submit-text>Create Poll</span>
                            </button>

                            <a
                                href="{{ route('polls.index') }}"
                                class="inline-flex w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Cancel
                            </a>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 flex-none text-indigo-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25 12 10.5m0 0 .75.75M12 10.5v5.25m9-3.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <div>
                                <h4 class="text-sm font-bold text-indigo-900">Poll Tips</h4>
                                <ul class="mt-2 space-y-2 text-xs leading-5 text-indigo-800">
                                    <li>Keep the question direct and easy to understand.</li>
                                    <li>Use images for character, cover, or card voting.</li>
                                    <li>Require authenticated voting for official contests.</li>
                                    <li>Use an end date to create urgency around limited polls.</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </aside>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('[data-poll-create-form]');

                if (!form) {
                    return;
                }

                const optionsContainer = form.querySelector('[data-options-container]');
                const optionTemplate = form.querySelector('[data-option-template]');
                const addOptionButton = form.querySelector('[data-add-option]');
                const optionCount = form.querySelector('[data-option-count]');
                const selectionType = form.querySelector('[data-selection-type]');
                const maximumSelections = form.querySelector('[data-maximum-selections]');
                const selectionHelp = form.querySelector('[data-selection-help]');
                const questionInput = form.querySelector('[data-poll-question]');
                const questionCount = form.querySelector('[data-question-count]');
                const startsAt = form.querySelector('[data-starts-at]');
                const endsAt = form.querySelector('[data-ends-at]');
                const scheduleError = form.querySelector('[data-schedule-error]');
                const publishToggle = form.querySelector('[data-publish-toggle]');
                const statusLabel = form.querySelector('[data-status-label]');
                const statusDot = form.querySelector('[data-status-dot]');
                const submitButton = form.querySelector('[data-submit-button]');
                const submitSpinner = form.querySelector('[data-submit-spinner]');
                const submitText = form.querySelector('[data-submit-text]');

                const maximumOptionCount = 20;
                const minimumOptionCount = 2;
                let isSubmitting = false;

                const rows = () => [...optionsContainer.querySelectorAll('[data-option-row]')];

                function updateOptionRows() {
                    const currentRows = rows();

                    currentRows.forEach((row, index) => {
                        const number = row.querySelector('[data-option-number]');

                        if (number) {
                            number.textContent = index + 1;
                        }

                        row.querySelectorAll('[data-field]').forEach((field) => {
                            const fieldName = field.dataset.field;
                            field.name = `options[${index}][${fieldName}]`;
                        });

                        const existingNamedFields = row.querySelectorAll('[name^="options["]');

                        existingNamedFields.forEach((field) => {
                            field.name = field.name.replace(/options\[\d+\]/, `options[${index}]`);
                        });

                        const removeButton = row.querySelector('[data-remove-option]');

                        if (removeButton) {
                            removeButton.disabled = currentRows.length <= minimumOptionCount;
                        }
                    });

                    if (optionCount) {
                        optionCount.textContent = currentRows.length;
                    }

                    if (addOptionButton) {
                        addOptionButton.disabled = currentRows.length >= maximumOptionCount;
                    }
                }

                function addOption() {
                    if (rows().length >= maximumOptionCount || !optionTemplate) {
                        return;
                    }

                    const fragment = optionTemplate.content.cloneNode(true);
                    optionsContainer.appendChild(fragment);
                    updateOptionRows();

                    const newRow = rows().at(-1);
                    newRow?.querySelector('[data-option-name]')?.focus();
                }

                optionsContainer.addEventListener('click', (event) => {
                    const removeButton = event.target.closest('[data-remove-option]');

                    if (!removeButton || rows().length <= minimumOptionCount) {
                        return;
                    }

                    removeButton.closest('[data-option-row]')?.remove();
                    updateOptionRows();
                });

                addOptionButton?.addEventListener('click', addOption);

                function updateSelectionRules() {
                    const isMultiple = selectionType?.value === 'multiple';

                    if (!maximumSelections) {
                        return;
                    }

                    maximumSelections.readOnly = !isMultiple;
                    maximumSelections.classList.toggle('bg-gray-100', !isMultiple);
                    maximumSelections.classList.toggle('text-gray-500', !isMultiple);

                    if (!isMultiple) {
                        maximumSelections.value = 1;
                    }

                    if (selectionHelp) {
                        selectionHelp.textContent = isMultiple
                            ? 'Choose how many options a voter may select.'
                            : 'Single-choice polls are limited to one selection.';
                    }
                }

                selectionType?.addEventListener('change', updateSelectionRules);

                function updateQuestionCount() {
                    if (questionInput && questionCount) {
                        questionCount.textContent = questionInput.value.length;
                    }
                }

                questionInput?.addEventListener('input', updateQuestionCount);

                function validateSchedule() {
                    if (!startsAt?.value || !endsAt?.value) {
                        scheduleError?.classList.add('hidden');
                        return true;
                    }

                    const valid = new Date(endsAt.value) > new Date(startsAt.value);

                    if (scheduleError) {
                        scheduleError.textContent = valid
                            ? ''
                            : 'The end time must be after the start time.';
                        scheduleError.classList.toggle('hidden', valid);
                    }

                    return valid;
                }

                startsAt?.addEventListener('change', () => {
                    if (endsAt && startsAt.value) {
                        endsAt.min = startsAt.value;
                    }

                    validateSchedule();
                    updateStatus();
                });

                endsAt?.addEventListener('change', () => {
                    validateSchedule();
                    updateStatus();
                });

                function updateStatus() {
                    if (!statusLabel || !statusDot) {
                        return;
                    }

                    statusDot.className = 'h-2.5 w-2.5 rounded-full';

                    if (!publishToggle?.checked) {
                        statusLabel.textContent = 'Draft';
                        statusDot.classList.add('bg-gray-400');
                        return;
                    }

                    const now = new Date();
                    const start = startsAt?.value ? new Date(startsAt.value) : null;
                    const end = endsAt?.value ? new Date(endsAt.value) : null;

                    if (end && end < now) {
                        statusLabel.textContent = 'Ended';
                        statusDot.classList.add('bg-red-500');
                    } else if (start && start > now) {
                        statusLabel.textContent = 'Scheduled';
                        statusDot.classList.add('bg-blue-500');
                    } else {
                        statusLabel.textContent = 'Active';
                        statusDot.classList.add('bg-green-500');
                    }
                }

                publishToggle?.addEventListener('change', updateStatus);

                form.addEventListener('submit', (event) => {
                    if (isSubmitting) {
                        event.preventDefault();
                        return;
                    }

                    if (!validateSchedule()) {
                        event.preventDefault();
                        endsAt?.focus();
                        return;
                    }

                    if (rows().length < minimumOptionCount) {
                        event.preventDefault();
                        return;
                    }

                    isSubmitting = true;

                    if (submitButton) {
                        submitButton.disabled = true;
                    }

                    submitSpinner?.classList.remove('hidden');

                    if (submitText) {
                        submitText.textContent = 'Creating Poll...';
                    }
                });

                updateOptionRows();
                updateSelectionRules();
                updateQuestionCount();
                validateSchedule();
                updateStatus();
            });
        </script>
    @endpush
</x-app-layout>
