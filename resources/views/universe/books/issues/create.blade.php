<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-black leading-tight text-gray-900">
                    {{ isset($issue->id) ? __('Edit Chapter') : __('Create Chapter') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Build and publish chapters for your Enterblaze universe.</p>
            </div>
        </div>
    </x-slot>

    @php
        $currentStep = (int) ($step ?? 1);

        $steps = [
            1 => [
                'title' => 'Chapter Info',
                'description' => 'Title, number, price, and summary',
            ],
            2 => [
                'title' => 'Chapter Cover',
                'description' => 'Upload cover artwork',
            ],
            3 => [
                'title' => 'Upload Story',
                'description' => 'Add your chapter pages/files',
            ],
            4 => [
                'title' => 'Submit',
                'description' => 'Review and finish',
            ],
        ];

        $resolvedUniverseId = $issue->book->universe->id ?? $universe_id ?? $universe->id ?? request('universe_id');
        $resolvedBookId = $issue->book->id ?? $book_id ?? request('book_id');
    @endphp

    <div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-8">

            {{-- Hero --}}
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="relative isolate px-6 py-8 sm:px-8">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-indigo-50 via-white to-white"></div>

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                Issue Builder
                            </p>

                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                {{ isset($issue->id) ? 'Edit Your Chapter' : 'Create Your Chapter' }}
                            </h1>

                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                Add the chapter details, upload your cover, attach your story files, then submit it to your book library.
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:min-w-[320px]">
                            <div class="rounded-3xl border border-gray-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Current Step</p>
                                <p class="mt-2 text-2xl font-black text-gray-950">{{ $currentStep }}/4</p>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Status</p>
                                <p class="mt-2 text-2xl font-black text-gray-950">
                                    {{ isset($issue->id) ? 'Editing' : 'Draft' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Steps --}}
            <div class="rounded-3xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    @foreach($steps as $number => $stepItem)
                        @php
                            $isActive = $currentStep === $number;
                            $isComplete = $currentStep > $number;
                        @endphp

                        @if(isset($issue->id))
                            @if($number === 4)
                                <form method="GET" action="{{ route('issues.index', ['universe_id' => $resolvedUniverseId, 'book_id' => $resolvedBookId]) }}">
                                    <input type="hidden" name="universe_id" value="{{ $resolvedUniverseId }}">
                                    <input type="hidden" name="book_id" value="{{ $resolvedBookId }}">
                                    <input type="hidden" name="step" value="4">
                            @else
                                <form method="GET" action="{{ route('issues.edit', ['universe_id' => $resolvedUniverseId, 'book_id' => $resolvedBookId, 'issue_id' => $issue->id]) }}">
                                    <input type="hidden" name="universe_id" value="{{ $resolvedUniverseId }}">
                                    <input type="hidden" name="book_id" value="{{ $resolvedBookId }}">
                                    <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                    <input type="hidden" name="step" value="{{ $number }}">
                            @endif
                        @else
                            <form method="GET" action="">
                                <input type="hidden" name="universe_id" value="{{ $resolvedUniverseId }}">
                                <input type="hidden" name="book_id" value="{{ $resolvedBookId }}">
                                <input type="hidden" name="step" value="{{ $number === 1 ? 1 : $currentStep }}">
                        @endif
                            @csrf

                            <button
                                type="submit"
                                class="group flex w-full items-start gap-4 rounded-3xl border p-4 text-left transition
                                {{ $isActive ? 'border-indigo-200 bg-indigo-50 shadow-sm' : 'border-gray-200 bg-white hover:border-indigo-200 hover:bg-indigo-50/40' }}"
                            >
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl text-sm font-black
                                    {{ $isActive ? 'bg-indigo-600 text-white' : ($isComplete ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-500') }}">
                                    @if($isComplete)
                                        ✓
                                    @else
                                        {{ $number }}
                                    @endif
                                </span>

                                <span>
                                    <span class="block text-sm font-black {{ $isActive ? 'text-indigo-900' : 'text-gray-900' }}">
                                        Step {{ $number }} - {{ $stepItem['title'] }}
                                    </span>
                                    <span class="mt-1 block text-xs leading-5 text-gray-500">
                                        {{ $stepItem['description'] }}
                                    </span>
                                </span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>

            @if($currentStep > 1)
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    @include('components.universe.books.issues.issue-uploader.issue-form-step-'.$currentStep)
                </div>
            @else
                <form method="POST" action="{{ route('issues.store', ['universe_id' => $universe_id, 'book_id' => $book_id]) }}">
                    @csrf

                    <input type="hidden" name="step" value="1">
                    <input type="hidden" name="universe_id" value="{{ $universe_id }}">
                    <input type="hidden" name="book_id" value="{{ $book_id }}">

                    @if(isset($issue->id))
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                    @endif

                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                        {{-- Main Form --}}
                        <div class="lg:col-span-8">
                            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                                <div class="border-b border-gray-200 pb-6">
                                    <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                        Chapter Details
                                    </p>

                                    <h2 class="mt-3 text-2xl font-black text-gray-950">
                                        Publish Your Chapter
                                    </h2>

                                    <p class="mt-2 text-sm leading-6 text-gray-600">
                                        Fill out the main information readers will see before opening this chapter.
                                    </p>
                                </div>

                                @if ($errors->any())
                                    <div class="mt-6 rounded-3xl border border-red-200 bg-red-50 p-5">
                                        <h3 class="text-sm font-black text-red-900">Please fix these fields</h3>
                                        <ul class="mt-3 space-y-1 text-sm text-red-700">
                                            @foreach ($errors->all() as $error)
                                                <li>* {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="issue_title" class="block text-sm font-black text-gray-900">
                                            Chapter Title
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="issue_title"
                                                id="issue_title"
                                                autocomplete="issue_title"
                                                value="{{ $issue->issue_title ?? '' }}"
                                                class="block w-full rounded-2xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                                placeholder="Example: The First Gate"
                                            >
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="issue_number" class="block text-sm font-black text-gray-900">
                                            Issue #
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="number"
                                                name="issue_number"
                                                id="issue_number"
                                                value="{{ $issue->issue_number ?? '' }}"
                                                autocomplete="issue_number"
                                                class="block w-full rounded-2xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                                placeholder="1"
                                            >
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="issue_price" class="block text-sm font-black text-gray-900">
                                            Reservation Price
                                        </label>

                                        <p class="mt-1 text-xs leading-5 text-gray-500">
                                            Set the future price once this issue drops.
                                        </p>

                                        <div class="mt-2">
                                            <div class="relative">
                                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-sm font-bold text-gray-400">$</span>
                                                <input
                                                    type="number"
                                                    name="issue_price"
                                                    id="issue_price"
                                                    autocomplete="issue_price"
                                                    min="5.00"
                                                    step="0.01"
                                                    value="{{ $issue->issue_price ?? '' }}"
                                                    class="block w-full rounded-2xl border-0 bg-white py-3 pl-8 pr-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                                    placeholder="25.00"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                            <div class="relative flex items-start">
                                                <div class="flex h-6 items-center">
                                                    <input
                                                        id="issue_is_adult"
                                                        name="issue_is_adult"
                                                        value="1"
                                                        type="checkbox"
                                                        @checked(!empty($issue->issue_is_adult))
                                                        class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                    >
                                                </div>

                                                <div class="ml-3 text-sm leading-6">
                                                    <label for="issue_is_adult" class="font-black text-gray-900">
                                                        Adults Only
                                                    </label>

                                                    <p class="text-gray-500">
                                                        Mark this chapter if it contains mature content.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="issue_description" class="block text-sm font-black text-gray-900">
                                            Chapter Summary
                                        </label>

                                        <div class="mt-2">
                                            <textarea
                                                id="issue_description"
                                                name="issue_description"
                                                rows="6"
                                                class="block w-full rounded-3xl border-0 bg-white px-4 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                                placeholder="Write a few sentences about what happens in this chapter."
                                            >{{ $issue->issue_description ?? '' }}</textarea>
                                        </div>

                                        <p class="mt-3 text-sm leading-6 text-gray-500">
                                            Keep it exciting, clear, and spoiler-light.
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">
                                    <a
                                        href="{{ url()->previous() }}"
                                        class="inline-flex justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm hover:bg-gray-50"
                                    >
                                        Cancel
                                    </a>

                                    <button
                                        type="submit"
                                        class="inline-flex justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    >
                                        Save & Continue
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Sidebar --}}
                        <div class="lg:col-span-4">
                            <div class="sticky top-6 space-y-6">
                                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">
                                        Creator Tip
                                    </p>

                                    <h3 class="mt-3 text-xl font-black text-gray-950">
                                        Make the title collectible.
                                    </h3>

                                    <p class="mt-3 text-sm leading-6 text-gray-600">
                                        Strong chapter titles help readers remember big moments and make your issue library feel premium.
                                    </p>
                                </div>

                                <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6 shadow-sm">
                                    <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                        Next Up
                                    </p>

                                    <h3 class="mt-3 text-xl font-black text-indigo-950">
                                        Chapter Cover
                                    </h3>

                                    <p class="mt-3 text-sm leading-6 text-indigo-800/80">
                                        After saving this page, upload the artwork readers will see in the chapter library.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
