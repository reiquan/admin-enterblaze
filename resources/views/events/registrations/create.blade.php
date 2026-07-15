<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-600">
                    Events
                </p>
                <h2 class="text-xl font-semibold leading-tight text-gray-900">
                    {{ isset($event_registration->id) ? __('Edit Event Registration') : __('Create Event Registration') }}
                </h2>
            </div>

            <a
                href="{{ route('events.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to events
            </a>
        </div>
    </x-slot>

    @php
        $isEditing = isset($event_registration) && $event_registration;
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
                <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            Event registration setup
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Configure who can register, how many spots are available, and when registration opens.
                        </p>
                    </div>

                    <div class="inline-flex w-fit items-center gap-3 rounded-full bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">
                            {{ $step ?? 1 }}
                        </span>
                        Step {{ $step ?? 1 }}
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-4">
                    @if($isEditing)
                        <form method="GET" action="{{ route('events.registrations.edit', $event_registration->id) }}">
                            <input type="hidden" name="step" value="1">
                            <input type="hidden" name="event_id" value="{{ $event_registration->id }}">

                            <button
                                type="submit"
                                class="inline-flex items-center gap-3 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-left text-sm font-semibold text-indigo-700 transition hover:border-indigo-300 hover:bg-indigo-100"
                                aria-current="step"
                            >
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">1</span>
                                Event Registration Info
                            </button>
                        </form>
                    @else
                        <div class="inline-flex items-center gap-3 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs text-white">1</span>
                            Event Registration Info
                        </div>
                    @endif
                </div>
            </div>

            @if(($step ?? 1) > 1)
                @include('components.events.registrations.registration-form-step-'.$step)
            @else
                <form
                    method="POST"
                    action="{{ $isEditing
                        ? route('events.registrations.update', [
                            'event_registration_id' => $event_registration->id,
                            'step' => 1,
                        ])
                        : route('events.registrations.store', $event->id) }}"
                    class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
                >
                    @csrf

                    @if($isEditing)
                        @method('PUT')
                    @else
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                    @endif

                    <div class="border-b border-gray-100 px-6 py-6 sm:px-8">
                        <h1 class="text-lg font-semibold text-gray-900">
                            Registration settings
                        </h1>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Add the public-facing registration details, capacity, fee, and availability window.
                        </p>
                    </div>

                    <div class="space-y-8 px-6 py-8 sm:px-8">
                        @if($errors->any())
                            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                                <div class="flex gap-3">
                                    <svg class="mt-0.5 h-5 w-5 flex-none text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800">Please correct the following:</p>
                                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div>
                                <label for="registration_name" class="block text-sm font-semibold text-gray-900">
                                    Registration name
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Example: General Admission, Artist Alley, or VIP Guest.
                                </p>
                                <input
                                    type="text"
                                    name="registration_name"
                                    id="registration_name"
                                    value="{{ old('registration_name', $event_registration->registration_name ?? '') }}"
                                    class="mt-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
                                    placeholder="Enter a registration name"
                                    required
                                >
                                @error('registration_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="registration_type" class="block text-sm font-semibold text-gray-900">
                                    Registration type
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Choose the audience or participant group this registration is for.
                                </p>
                                <select
                                    id="registration_type"
                                    name="registration_type"
                                    class="mt-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
                                    required
                                >
                                    @foreach($registrationTypes as $registrationType)
                                        <option
                                            value="{{ $registrationType }}"
                                            @selected(old('registration_type', $event_registration->registration_type ?? '') === $registrationType)
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
                                <label for="registration_limit" class="block text-sm font-semibold text-gray-900">
                                    Registration limit
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Set the maximum number of registrations available.
                                </p>
                                <input
                                    type="number"
                                    name="registration_limit"
                                    id="registration_limit"
                                    value="{{ old('registration_limit', $event_registration->registration_limit ?? '') }}"
                                    min="0"
                                    class="mt-3 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
                                    placeholder="0"
                                    required
                                >
                                @error('registration_limit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="registration_fee" class="block text-sm font-semibold text-gray-900">
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
                                        value="{{ old('registration_fee', $event_registration->registration_fee ?? '') }}"
                                        min="0"
                                        step="0.01"
                                        class="block w-full rounded-xl border-gray-300 pl-8 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
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
                            <label for="registration_description" class="block text-sm font-semibold text-gray-900">
                                Registration description
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Explain who should register and what is included.
                            </p>
                            <textarea
                                rows="5"
                                name="registration_description"
                                id="registration_description"
                                class="mt-3 block w-full resize-y rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3"
                                placeholder="Describe this registration option..."
                            >{{ old('registration_description', $event_registration->registration_description ?? '') }}</textarea>
                            @error('registration_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 sm:p-6">
                            <div class="mb-5">
                                <h2 class="text-sm font-semibold text-gray-900">Registration availability</h2>
                                <p class="mt-1 text-xs text-gray-500">
                                    Select when attendees can begin and stop submitting registrations.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <div>
                                    <label for="registration_start_date" class="block text-sm font-semibold text-gray-900">
                                        Start date and time
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="registration_start_date"
                                        id="registration_start_date"
                                        value="{{ old('registration_start_date', $event_registration->registration_start_date ?? '') }}"
                                        class="mt-3 block w-full rounded-xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required
                                    >

                                    @error('registration_start_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="registration_end_date" class="block text-sm font-semibold text-gray-900">
                                        End date and time
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="registration_end_date"
                                        id="registration_end_date"
                                        value="{{ old('registration_end_date', $event_registration->registration_end_date ?? '') }}"
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

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
                        <a
                            href="{{ route('events.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            name="type"
                            value="{{ Route::is('events.registrations.edit') ? 'edit' : '' }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 12.75 10.5 18l9-13.5" />
                            </svg>
                            {{ $isEditing ? 'Update Event Registration' : 'Save Event Registration' }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
