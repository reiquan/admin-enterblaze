<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Top Header --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <x-application-logo class="block h-11 w-auto" />

                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                Enterblaze Events
                            </p>
                            <h1 class="mt-1 text-2xl font-black tracking-tight text-gray-950">
                                Event Overview
                            </h1>
                        </div>
                    </div>

                    <a
                        href="{{ route('events.index') }}"
                        class="hidden rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50 sm:inline-flex"
                    >
                        Back to Events
                    </a>
                </div>
            </div>

            {{-- Event Hero --}}
            <div class="grid gap-0 lg:grid-cols-2">
                <div class="relative min-h-[280px] bg-gray-100">
                    @if(!empty($event->event_promo_image))
                        <img
                            class="absolute inset-0 h-full w-full object-cover"
                            src="{{ Storage::disk('s3-public')->url($event->event_promo_image) }}"
                            alt="{{ $event->event_name ?? 'Event promo image' }}"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-gray-950/20 to-transparent"></div>
                    @else
                        <div class="flex h-full min-h-[280px] items-center justify-center bg-gradient-to-br from-indigo-50 to-gray-100">
                            <div class="text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-indigo-600 shadow-sm ring-1 ring-gray-200">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A1.5 1.5 0 0 1 19.5 20.25h-15A1.5 1.5 0 0 1 3 18.75V8.25A1.5 1.5 0 0 1 4.5 6.75Z" />
                                    </svg>
                                </div>
                                <p class="mt-4 text-sm font-bold text-gray-500">No promo image uploaded</p>
                            </div>
                        </div>
                    @endif

                    <div class="absolute bottom-5 left-5">
                        @if($event->is_active ?? false)
                            <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-xs font-black uppercase tracking-widest text-green-700 ring-1 ring-green-200">
                                Published
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-orange-100 px-4 py-2 text-xs font-black uppercase tracking-widest text-orange-700 ring-1 ring-orange-200">
                                Draft
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col justify-center p-6 sm:p-8 lg:p-10">
                    <p class="text-sm font-black uppercase tracking-[0.25em] text-indigo-600">
                        {{ $event->event_start_date ?? 'Start Date' }}
                        @if(!empty($event->event_end_date))
                            <span class="text-gray-300">/</span> {{ $event->event_end_date }}
                        @endif
                    </p>

                    <h2 class="mt-4 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                        {{ $event->event_name ?? 'Untitled Event' }}
                    </h2>

                    @if(!empty($event->subtitle))
                        <p class="mt-3 text-base font-semibold text-gray-600">
                            {{ $event->subtitle }}
                        </p>
                    @endif

                    @if(!empty($event->event_about))
                        <p class="mt-5 line-clamp-5 text-sm leading-7 text-gray-500">
                            {{ $event->event_about }}
                        </p>
                    @endif

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Registered Guests</p>
                            <p class="mt-2 text-3xl font-black text-gray-950">{{ $event->registered ?? 0 }}</p>
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-xs font-black uppercase tracking-widest text-gray-400">Total Revenue</p>
                            <p class="mt-2 text-3xl font-black text-gray-950">${{ $event->revenue ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Registration CTA --}}
        <form
            action="{{ route('events.registrations.create', $event->id) }}"
            method="GET"
            class="mt-8"
        >
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <button
                type="submit"
                class="group block w-full rounded-3xl border-2 border-dashed border-gray-300 bg-white p-10 text-center shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50"
            >
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 transition group-hover:bg-indigo-600 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </span>

                <span class="mt-4 block text-lg font-black text-gray-950">
                    Create a New Registration
                </span>

                <span class="mt-2 block text-sm text-gray-500">
                    Add tickets, vendor passes, guest registrations, or event access types.
                </span>
            </button>
        </form>

        {{-- Registrations --}}
        <div class="mt-8 rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                            Registration Library
                        </p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                            Event Registrations
                        </h3>
                    </div>

                    <p class="text-sm font-bold text-gray-500">
                        {{ isset($event->registrations) ? $event->registrations->count() : 0 }} total
                    </p>
                </div>
            </div>

            @if(isset($event->registrations) && $event->registrations->count())
                <div class="grid gap-5 p-6 sm:p-8 lg:grid-cols-2">
                    @foreach($event->registrations as $registration)
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5 transition hover:-translate-y-1 hover:bg-white hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">
                                        Registration #{{ $registration->id }}
                                    </p>

                                    <h4 class="mt-2 text-xl font-black text-gray-950">
                                        {{ $registration->registration_name }}
                                    </h4>

                                    <p class="mt-2 text-sm font-semibold text-gray-500">
                                        {{ $registration->registration_type }}
                                    </p>
                                </div>

                                @if($registration->registration_is_active)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black uppercase tracking-widest text-green-700">
                                        Published
                                    </span>
                                @else
                                    <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-black uppercase tracking-widest text-orange-700">
                                        Draft
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5 rounded-2xl border border-gray-200 bg-white p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Registration Window</p>
                                <p class="mt-1 text-sm font-bold text-gray-900">
                                    {{ $registration->registration_start_date ?? 'No start date' }}
                                    @if(!empty($registration->registration_end_date))
                                        - {{ $registration->registration_end_date }}
                                    @endif
                                </p>
                            </div>

                            <div class="mt-5 grid gap-3 sm:grid-cols-4">
                                @if($registration->registration_is_active)
                                    <button
                                        id="unpublish{{ $registration->id }}"
                                        onclick="publishAction('unpublish', '{{ $registration->id }}', '{{ $event->id }}')"
                                        type="button"
                                        class="rounded-2xl bg-yellow-100 px-4 py-3 text-sm font-black text-yellow-800 transition hover:bg-yellow-200"
                                    >
                                        Unpublish
                                    </button>
                                @else
                                    <button
                                        id="publish{{ $registration->id }}"
                                        onclick="publishAction('publish', '{{ $registration->id }}', '{{ $event->id }}')"
                                        type="button"
                                        class="rounded-2xl bg-green-100 px-4 py-3 text-sm font-black text-green-800 transition hover:bg-green-200"
                                    >
                                        Publish
                                    </button>
                                @endif

                                <form action="{{ route('events.registrations.edit', ['event_id' => $event->id, 'registration_id' => $registration->id]) }}" method="GET">
                                    <input type="hidden" id="registration_id{{ $registration->id }}" name="registration_id" value="{{ $registration->id }}">

                                    <button
                                        type="submit"
                                        class="w-full rounded-2xl bg-indigo-50 px-4 py-3 text-sm font-black text-indigo-700 transition hover:bg-indigo-100"
                                    >
                                        Edit
                                    </button>
                                </form>

                                <a
                                    href="{{ route('events.registrations.show', ['event_id' => $event->id, 'registration_id' => $registration->id, 'event_registration_id' => $registration->id]) }}"
                                    class="rounded-2xl bg-white px-4 py-3 text-center text-sm font-black text-gray-800 ring-1 ring-gray-200 transition hover:bg-gray-100"
                                >
                                    View
                                </a>

                                <button
                                    onclick="confirmDelete('{{ $registration->id }}', '{{ $event->id }}')"
                                    type="button"
                                    class="rounded-2xl bg-red-50 px-4 py-3 text-sm font-black text-red-700 transition hover:bg-red-100"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8">
                    <div class="rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-12 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-gray-500 shadow-sm ring-1 ring-gray-200">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0v.75H4.5v-.75Z" />
                            </svg>
                        </div>

                        <h3 class="mt-5 text-xl font-black text-gray-950">
                            No Registrations Yet
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Create your first registration option for this event.
                        </p>

                        <form
                            action="{{ route('events.registrations.create', $event->id) }}"
                            method="GET"
                            class="mt-6"
                        >
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <button
                                type="submit"
                                class="inline-flex rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700"
                            >
                                Create Registration
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
