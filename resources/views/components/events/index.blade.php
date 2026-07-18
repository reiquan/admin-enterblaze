<div class="bg-gray-50">
    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 bg-white px-6 py-8 lg:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A1.5 1.5 0 0 1 19.5 20.25h-15A1.5 1.5 0 0 1 3 18.75V8.25A1.5 1.5 0 0 1 4.5 6.75Z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Enterblaze Admin</p>
                            <h1 class="mt-2 text-3xl font-black tracking-tight text-gray-950">Events</h1>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                                Manage your conventions, creator meetups, panels, tournaments, and live Enterblaze experiences.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Create Event
                    </a>
                </div>
            </div>

            <div class="grid gap-4 border-b border-gray-200 bg-gray-50 px-6 py-6 sm:grid-cols-3 lg:px-8">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Total Events</p>
                    <p class="mt-2 text-3xl font-black text-gray-950">{{ $events->count() ?? 0 }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Published</p>
                    <p class="mt-2 text-3xl font-black text-green-600">{{ $events->where('is_active', true)->count() ?? 0 }}</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Unpublished</p>
                    <p class="mt-2 text-3xl font-black text-orange-500">{{ $events->where('is_active', false)->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="px-6 py-8 lg:px-8">
                <a href="{{ route('events.create') }}" class="group relative block rounded-3xl border-2 border-dashed border-gray-300 bg-white p-8 text-center transition hover:border-indigo-400 hover:bg-indigo-50">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 transition group-hover:bg-indigo-600 group-hover:text-white">
                        <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M24 10v28m14-14H10" />
                        </svg>
                    </div>

                    <span class="mt-4 block text-sm font-black text-gray-950">Create a new Event</span>
                    <span class="mt-1 block text-sm text-gray-500">Add a new event to your Enterblaze event calendar.</span>
                </a>

                <div class="mt-8 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    @if(isset($events) && $events->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-gray-500">Event</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-gray-500">Date</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-gray-500">Location</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-gray-500">Status</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-black uppercase tracking-widest text-gray-500">Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach($events as $event)
                                        <tr class="transition hover:bg-gray-50">
                                            <td class="whitespace-nowrap px-6 py-5">
                                                <div>
                                                    <div class="text-sm font-black text-gray-950">{{ $event->event_name }}</div>
                                                    <div class="mt-1 text-xs font-medium text-gray-400">Event #{{ $event->id }}</div>
                                                </div>
                                            </td>

                                            <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                                <div class="font-semibold text-gray-900">{{ $event->event_start_date }}</div>
                                                <div class="mt-1 text-xs text-gray-400">to {{ $event->event_end_date }}</div>
                                            </td>

                                            <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-600">
                                                <div class="font-semibold text-gray-900">{{ $event->event_city }}</div>
                                                <div class="mt-1 text-xs text-gray-400">{{ $event->event_zip }}</div>
                                            </td>

                                            <td class="whitespace-nowrap px-6 py-5">
                                                <input type="hidden" id="{{ $event->id }}" value="{{ $event->id }}">

                                                @if($event->is_active)
                                                    <button id="unpublish{{ $event->id }}" onclick="publishAction('unpublish', '{{ $event->id }}')" class="inline-flex items-center rounded-full bg-green-50 px-4 py-2 text-xs font-black uppercase tracking-widest text-green-700 ring-1 ring-inset ring-green-200 transition hover:bg-green-100">
                                                        Published
                                                    </button>
                                                @else
                                                    <button id="publish{{ $event->id }}" onclick="publishAction('publish', '{{ $event->id }}')" class="inline-flex items-center rounded-full bg-orange-50 px-4 py-2 text-xs font-black uppercase tracking-widest text-orange-700 ring-1 ring-inset ring-orange-200 transition hover:bg-orange-100">
                                                        Unpublished
                                                    </button>
                                                @endif
                                            </td>

                                            <td class="whitespace-nowrap px-6 py-5 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <form action="{{ route('events.edit', ['event_id' => $event->id]) }}" method="GET">
                                                        <input type="hidden" id="event_id{{ $event->id }}" name="event_id" value="{{ $event->id }}">
                                                        <button class="rounded-xl bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700 transition hover:bg-indigo-100">
                                                            Edit
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('events.show', ['event_id' => $event->id]) }}" class="rounded-xl bg-gray-100 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-200">
                                                        View
                                                    </a>

                                                    <button onclick="confirmDelete('{{ $event->id }}')" class="rounded-xl bg-red-50 px-3 py-2 text-xs font-bold text-red-700 transition hover:bg-red-100">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-16 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A1.5 1.5 0 0 1 19.5 20.25h-15A1.5 1.5 0 0 1 3 18.75V8.25A1.5 1.5 0 0 1 4.5 6.75Z" />
                                </svg>
                            </div>

                            <h3 class="mt-5 text-lg font-black text-gray-950">No events scheduled</h3>
                            <p class="mt-2 text-sm text-gray-500">Create your first event and start building your event lineup.</p>

                            <a href="{{ route('events.create') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-500">
                                Create Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
