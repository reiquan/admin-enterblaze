<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Edit Event Registration') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Update the registration settings for this event.
                </p>
            </div>

            <a
                href="{{ route('events.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Back to events
            </a>
        </div>
    </x-slot>

    @php
        $registrationTypes = [
            'Guest',
            'Special Guest',
            'Vendor',
            'Artist',
            'Mangaka',
            'Food Vendor',
            'Tournament',
        ];
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-5">
                    <nav aria-label="Breadcrumb">
                        <ol class="flex flex-wrap items-center gap-2 text-sm">
                            <li>
                                <a
                                    href="{{ route('events.index') }}"
                                    class="font-medium text-gray-500 transition hover:text-indigo-600"
                                >
                                    Events
                                </a>
                            </li>

                            <li class="text-gray-300" aria-hidden="true">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.24 4.24a.75.75 0 0 1 0 1.06l-4.24 4.24a.75.75 0 0 1-1.08 0Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </li>

                            <li>
                                <span class="font-semibold text-indigo-600">
                                    Event registration
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <div class="flex gap-3">
                        <svg
                            class="mt-0.5 h-5 w-5 flex-none text-red-500"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-11.25a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Zm0 6.5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <div>
                            <h3 class="text-sm font-semibold text-red-800">
                                Please correct the following errors:
                            </h3>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('events.registrations.update', [
                    'event_id' => $event_registration->event->id,
                    'registration_id' => $event_registration->id,
                ]) }}"
            >
                @csrf
   

                <input
                    type="hidden"
                    name="registration_id"
                    value="{{ $event_registration->id }}"
                >

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-6 sm:px-8">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-indigo-600">
                            Registration settings
                        </p>

                        <h1 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">
                            Edit event registration
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                            Update the registration name, audience, availability, dates, and fee.
                        </p>
                    </div>

                    <div class="space-y-8 px-6 py-8 sm:px-8">
                        <div class="grid grid-cols-1 gap-y-8 gap-x-12 lg:grid-cols-2">
                            <div>
                                <label
                                    for="registration_name"
                                    class="block text-sm font-semibold text-gray-900"
                                >
                                    Registration name
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Example: General Admission, Artist Alley, or VIP Guest.
                                </p>

                                <input
                                    type="text"
                                    name="registration_name"
                                    id="registration_name"
                                    value="{{ old('registration_name', $event_registration->registration_name) }}"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Enter a registration name"
                                    required
                                >

                                @error('registration_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="registration_type"
                                    class="block text-sm font-semibold text-gray-900"
                                >
                                    Registration type
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Choose the audience or participant group this registration is for.
                                </p>

                                <select
                                    id="registration_type"
                                    name="registration_type"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                >
                                    @foreach ($registrationTypes as $registrationType)
                                        <option
                                            value="{{ $registrationType }}"
                                            @selected(old('registration_type', $event_registration->registration_type) === $registrationType)
                                        >
                                            {{ $registrationType }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('registration_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="registration_limit"
                                    class="block text-sm font-semibold text-gray-900"
                                >
                                    Registration limit
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Set the maximum number of registrations available.
                                </p>

                                <input
                                    type="number"
                                    name="registration_limit"
                                    id="registration_limit"
                                    value="{{ old('registration_limit', $event_registration->registration_limit) }}"
                                    min="0"
                                    class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="0"
                                    required
                                >

                                @error('registration_limit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="registration_fee"
                                    class="block text-sm font-semibold text-gray-900"
                                >
                                    Registration fee
                                </label>

                                <p class="mt-1 text-xs text-gray-500">
                                    Enter 0 when this registration is free.
                                </p>

                                <div class="relative mt-3">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-sm text-gray-500">$</span>
                                    </div>

                                    <input
                                        type="number"
                                        name="registration_fee"
                                        id="registration_fee"
                                        value="{{ old('registration_fee', $event_registration->registration_fee) }}"
                                        min="0"
                                        step="0.01"
                                        class="block w-full rounded-xl border-gray-300 py-3 pl-10 pr-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="0.00"
                                        required
                                    >
                                </div>

                                @error('registration_fee')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label
                                for="registration_description"
                                class="block text-sm font-semibold text-gray-900"
                            >
                                Registration description
                            </label>

                            <p class="mt-1 text-xs text-gray-500">
                                Explain who should register and what is included.
                            </p>

                            <textarea
                                rows="5"
                                name="registration_description"
                                id="registration_description"
                                class="mt-3 block w-full resize-y rounded-xl border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Describe this registration option..."
                            >{{ old('registration_description', $event_registration->registration_description) }}</textarea>

                            @error('registration_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-200 pt-8">
                            <div class="mb-5">
                                <h2 class="text-base font-semibold text-gray-900">
                                    Registration availability
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Set when attendees can begin and stop registering.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-y-8 gap-x-12 lg:grid-cols-2">
                                <div>
                                    <label
                                        for="registration_start_date"
                                        class="block text-sm font-semibold text-gray-900"
                                    >
                                        Start date and time
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="registration_start_date"
                                        id="registration_start_date"
                                        value="{{ old(
                                            'registration_start_date',
                                            optional($event_registration->registration_start_date)->format('Y-m-d\TH:i')
                                                ?? $event_registration->registration_start_date
                                        ) }}"
                                        class="mt-3 block w-full rounded-xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required
                                    >

                                    @error('registration_start_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        for="registration_end_date"
                                        class="block text-sm font-semibold text-gray-900"
                                    >
                                        End date and time
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="registration_end_date"
                                        id="registration_end_date"
                                        value="{{ old(
                                            'registration_end_date',
                                            optional($event_registration->registration_end_date)->format('Y-m-d\TH:i')
                                                ?? $event_registration->registration_end_date
                                        ) }}"
                                        class="mt-3 block w-full rounded-xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required
                                    >

                                    @error('registration_end_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
                        <a
                            href="{{ route('events.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Update event registration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
