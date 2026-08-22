<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                    Customers
                </p>

                <h2 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                    Subscribers
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    View and manage users subscribed to Enterblaze services.
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white px-5 py-3 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                    Total Subscribers
                </p>

                <p class="mt-1 text-2xl font-black text-gray-950">
                    {{ $subscribers->total() }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="rounded-3xl border border-green-200 bg-green-50 p-5">
                    <p class="text-sm font-bold text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">
                                Subscribers
                            </p>

                            <p class="mt-3 text-3xl font-black text-gray-950">
                                {{ $subscribers->total() }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479
                                    3 3 0 0 0-4.682-2.72m.94
                                    3.198.001.031c0 .225-.012.447-.037.666A11.944
                                    11.944 0 0 1 12 21c-2.17
                                    0-4.207-.576-5.963-1.584A6.062
                                    6.062 0 0 1 6 18.719m12
                                    0a5.971 5.971 0 0
                                    0-.941-3.197m0 0A5.995
                                    5.995 0 0 0 12 12.75a5.995
                                    5.995 0 0 0-5.058
                                    2.772m0 0a3 3 0 0
                                    0-4.681 2.72 8.986
                                    8.986 0 0 0
                                    3.74.477m.94-3.197a5.971
                                    5.971 0 0 0-.94
                                    3.197M15 6.75a3 3
                                    0 1 1-6 0 3 3 0 0
                                    1 6 0Zm6 3a2.25
                                    2.25 0 1 1-4.5
                                    0 2.25 2.25 0 0 1
                                    4.5 0Zm-13.5 0a2.25
                                    2.25 0 1 1-4.5
                                    0 2.25 2.25 0 0 1
                                    4.5 0Z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">
                        Creators
                    </p>

                    <p class="mt-3 text-3xl font-black text-gray-950">
                        {{ $subscribers->getCollection()->where('is_creator', true)->count() }}
                    </p>

                    <p class="mt-2 text-xs text-gray-500">
                        On this page
                    </p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">
                        Reader Accounts
                    </p>

                    <p class="mt-3 text-3xl font-black text-gray-950">
                        {{ $subscribers->getCollection()->where('is_creator', false)->count() }}
                    </p>

                    <p class="mt-2 text-xs text-gray-500">
                        On this page
                    </p>
                </div>

            </div>

            {{-- Subscriber List --}}
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="text-lg font-black text-gray-950">
                                Subscriber Directory
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Subscription accounts currently registered in the system.
                            </p>
                        </div>

                        <div class="relative">
                            <input
                                id="subscriberSearch"
                                type="search"
                                placeholder="Search subscribers..."
                                class="w-full rounded-2xl border-gray-300 bg-gray-50 pl-10 pr-4 text-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-72"
                            >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m2.1-5.4a7.5
                                    7.5 0 1 1-15 0 7.5
                                    7.5 0 0 1 15 0Z"
                                />
                            </svg>
                        </div>

                    </div>
                </div>

                @if($subscribers->count())

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">
                                        Subscriber
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">
                                        Account
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">
                                        Service
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">
                                        Subscriber User
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">
                                        Joined
                                    </th>
                                    
                                </tr>
                            </thead>

                            <tbody
                                id="subscriberTable"
                                class="divide-y divide-gray-100 bg-white"
                            >

                                @foreach($subscribers as $subscriber)

                                    <tr
                                        class="subscriber-row transition hover:bg-gray-50"
                                        data-search="{{ strtolower(
                                            ($subscriber->name ?? '') . ' ' .
                                            ($subscriber->email ?? '')
                                        ) }}"
                                    >

                                        {{-- Subscriber --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex items-center gap-4">

                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-black uppercase text-indigo-700">
                                                    {{ strtoupper(substr($subscriber->name ?? 'U', 0, 1)) }}
                                                </div>

                                                <div>
                                                    <p class="font-black text-gray-950">
                                                        {{ $subscriber->name }}
                                                    </p>

                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $subscriber->email }}
                                                    </p>
                                                </div>

                                            </div>

                                        </td>

                                        {{-- Account Type --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if($subscriber->is_creator)
                                                <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-black uppercase tracking-wider text-purple-700">
                                                    Creator
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-black uppercase tracking-wider text-gray-600">
                                                    Reader
                                                </span>
                                            @endif

                                        </td>

                                        {{-- Service --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if($subscriber->subscriber_service_id)

                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">
                                                    Service #{{ $subscriber->subscriber_service_id }}
                                                </span>

                                            @else

                                                <span class="text-sm font-bold text-gray-400">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Subscriber User --}}
                                        <td class="whitespace-nowrap px-6 py-5 text-sm font-bold text-gray-700">

                                            @if($subscriber->subscriber_user_id)
                                                #{{ $subscriber->subscriber_user_id }}
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif

                                        </td>

                                        {{-- Joined --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="text-sm font-bold text-gray-800">
                                                {{ optional($subscriber->created_at)->format('M j, Y') }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ optional($subscriber->created_at)->diffForHumans() }}
                                            </p>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-5">
                        {{ $subscribers->links() }}
                    </div>

                @else

                    <div class="px-6 py-20 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-7 w-7"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0
                                    3.741-.479 3 3 0 0
                                    0-4.682-2.72M15 6.75a3
                                    3 0 1 1-6 0 3 3
                                    0 0 1 6 0Z"
                                />
                            </svg>
                        </div>

                        <h3 class="mt-5 text-lg font-black text-gray-950">
                            No subscribers yet
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Subscription accounts will appear here once users begin subscribing.
                        </p>

                    </div>

                @endif

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const searchInput =
                document.getElementById('subscriberSearch');

            const rows =
                document.querySelectorAll('.subscriber-row');

            searchInput?.addEventListener('input', function () {

                const search =
                    this.value.toLowerCase().trim();

                rows.forEach(row => {

                    const searchable =
                        row.dataset.search || '';

                    row.style.display =
                        searchable.includes(search)
                            ? ''
                            : 'none';

                });

            });

        });
    </script>

</x-app-layout>