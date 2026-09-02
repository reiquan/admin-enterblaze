<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Blog Management') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Create, publish and manage Enterblaze articles.
                </p>
            </div>

            <a
                href="{{ route('blogs.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Create Blog
            </a>

        </div>
    </x-slot>


    <div class="py-12">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                SUCCESS MESSAGE
            ====================================================== --}}

            @if(session('success'))

                <div
                    class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-800"
                >
                    {{ session('success') }}
                </div>

            @endif



            {{-- =====================================================
                VALIDATION ERRORS
            ====================================================== --}}

            @if($errors->any())

                <div
                    class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4"
                >

                    <p class="font-semibold text-red-800">
                        Something went wrong.
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif



            {{-- =====================================================
                STAT CARDS
            ====================================================== --}}

            <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


                {{-- TOTAL --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Showing
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $blogs->total() }}
                            </p>

                        </div>

                        <div class="rounded-xl bg-indigo-50 p-3 text-indigo-600">

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
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V5.625a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>



                {{-- PUBLISHED --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Published
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ \App\Models\Blog::where('is_published', true)->count() }}
                            </p>

                        </div>

                        <div class="rounded-xl bg-green-50 p-3 text-green-600">

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
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>



                {{-- DRAFTS --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Drafts
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ \App\Models\Blog::where('status', 'draft')->count() }}
                            </p>

                        </div>

                        <div class="rounded-xl bg-yellow-50 p-3 text-yellow-600">

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
                                    d="M16.862 4.487 18.55 2.8a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 7.125V18a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 18V7.5a2.25 2.25 0 0 1 2.25-2.25H10.5"
                                />
                            </svg>

                        </div>

                    </div>

                </div>



                {{-- TOTAL VIEWS --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Total Views
                            </p>

                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ number_format(\App\Models\Blog::sum('views')) }}
                            </p>

                        </div>

                        <div class="rounded-xl bg-blue-50 p-3 text-blue-600">

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
                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =====================================================
                FILTERS
            ====================================================== --}}

            <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <form
                    action="{{ route('blogs.index') }}"
                    method="GET"
                    class="grid gap-4 lg:grid-cols-12"
                >


                    {{-- SEARCH --}}

                    <div class="lg:col-span-5">

                        <label
                            for="search"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-500"
                        >
                            Search
                        </label>

                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 text-gray-400"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                                    />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search articles..."
                                class="w-full rounded-lg border-gray-300 pl-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                    </div>



                    {{-- CATEGORY --}}

                    <div class="lg:col-span-3">

                        <label
                            for="category"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-500"
                        >
                            Category
                        </label>

                        <select
                            id="category"
                            name="category"
                            class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $categoryOption)

                                <option
                                    value="{{ $categoryOption }}"
                                    @selected($category === $categoryOption)
                                >
                                    {{ $categoryOption }}
                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- STATUS --}}

                    <div class="lg:col-span-2">

                        <label
                            for="status"
                            class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-500"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option value="">
                                All
                            </option>

                            <option
                                value="published"
                                @selected($status === 'published')
                            >
                                Published
                            </option>

                            <option
                                value="draft"
                                @selected($status === 'draft')
                            >
                                Draft
                            </option>

                        </select>

                    </div>



                    {{-- FILTER BUTTON --}}

                    <div class="flex items-end gap-2 lg:col-span-2">

                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Filter
                        </button>

                        <a
                            href="{{ route('blogs.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                            title="Clear Filters"
                        >
                            ×
                        </a>

                    </div>

                </form>

            </div>



            {{-- =====================================================
                BLOG TABLE
            ====================================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                @if($blogs->count())


                    {{-- DESKTOP TABLE --}}

                    <div class="hidden overflow-x-auto md:block">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Article
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Category
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Views
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Published
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500"
                                    >
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach($blogs as $blog)

                                    <tr class="transition hover:bg-gray-50">


                                        {{-- ARTICLE --}}

                                        <td class="px-6 py-5">

                                            <div class="flex items-center gap-4">


                                                {{-- FEATURED IMAGE --}}

                                                <div
                                                    class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100"
                                                >

                                                    @if($blog->featured_image)

                                                        <img
                                                            src="{{ Storage::disk('s3-public')->url($blog->featured_image) }}"
                                                            alt="{{ $blog->title }}"
                                                            class="h-full w-full object-cover"
                                                        >

                                                    @else

                                                        <div
                                                            class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-300"
                                                        >

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
                                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z"
                                                                />
                                                            </svg>

                                                        </div>

                                                    @endif

                                                </div>


                                                <div class="min-w-0">

                                                    <div class="flex items-center gap-2">

                                                        <a
                                                            href="{{ route('blogs.show', $blog->id) }}"
                                                            class="truncate font-semibold text-gray-900 transition hover:text-indigo-600"
                                                        >
                                                            {{ $blog->title }}
                                                        </a>


                                                        @if($blog->is_featured)

                                                            <span
                                                                class="rounded-full bg-purple-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-purple-700"
                                                            >
                                                                Featured
                                                            </span>

                                                        @endif

                                                    </div>


                                                    @if($blog->summary)

                                                        <p
                                                            class="mt-1 max-w-md truncate text-sm text-gray-500"
                                                        >
                                                            {{ $blog->summary }}
                                                        </p>

                                                    @endif


                                                    <p class="mt-2 text-xs text-gray-400">

                                                        @if($blog->user)

                                                            {{ $blog->user->name }}

                                                            <span class="mx-1">
                                                                •
                                                            </span>

                                                        @endif

                                                        {{ $blog->reading_time }} min read

                                                    </p>

                                                </div>

                                            </div>

                                        </td>



                                        {{-- CATEGORY --}}

                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if($blog->category)

                                                <span
                                                    class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700"
                                                >
                                                    {{ $blog->category }}
                                                </span>

                                            @else

                                                <span class="text-sm text-gray-400">
                                                    —
                                                </span>

                                            @endif

                                        </td>



                                        {{-- STATUS --}}

                                        <td class="whitespace-nowrap px-6 py-5">

                                            @if($blog->is_published)

                                                @if($blog->published_at && $blog->published_at->isFuture())

                                                    <span
                                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700"
                                                    >

                                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

                                                        Scheduled

                                                    </span>

                                                @else

                                                    <span
                                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700"
                                                    >

                                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                                        Published

                                                    </span>

                                                @endif

                                            @else

                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700"
                                                >

                                                    <span class="h-1.5 w-1.5 rounded-full bg-yellow-500"></span>

                                                    Draft

                                                </span>

                                            @endif

                                        </td>



                                        {{-- VIEWS --}}

                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="flex items-center gap-2 text-sm text-gray-600">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="h-4 w-4 text-gray-400"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                    />
                                                </svg>

                                                {{ number_format($blog->views) }}

                                            </div>

                                        </td>



                                        {{-- DATE --}}

                                        <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-500">

                                            @if($blog->published_at)

                                                <p>
                                                    {{ $blog->published_at->format('M d, Y') }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-400">
                                                    {{ $blog->published_at->format('g:i A') }}
                                                </p>

                                            @else

                                                <span class="text-gray-400">
                                                    Not published
                                                </span>

                                            @endif

                                        </td>



                                        {{-- ACTIONS --}}

                                        <td class="whitespace-nowrap px-6 py-5 text-right">

                                            <div class="flex items-center justify-end gap-2">


                                                {{-- VIEW --}}

                                                <a
                                                    href="{{ route('blogs.show', $blog->id) }}"
                                                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700"
                                                >
                                                    View
                                                </a>


                                                {{-- EDIT --}}

                                                <a
                                                    href="{{ route('blogs.edit', $blog->id) }}"
                                                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700"
                                                >
                                                    Edit
                                                </a>


                                                {{-- DELETE --}}

                                                <form
                                                    action="{{ route('blogs.destroy', $blog->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this blog post?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>



                    {{-- =====================================================
                        MOBILE CARDS
                    ====================================================== --}}

                    <div class="divide-y divide-gray-100 md:hidden">

                        @foreach($blogs as $blog)

                            <div class="p-5">

                                <div class="flex gap-4">

                                    <div
                                        class="h-20 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-gray-100"
                                    >

                                        @if($blog->featured_image)

                                            <img
                                                src="{{ config('filesystems.disks.s3.endpoint') . $blog->featured_image }}"
                                                alt="{{ $blog->title }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <div class="flex h-full items-center justify-center text-gray-300">
                                                No Image
                                            </div>

                                        @endif

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <a
                                            href="{{ route('blogs.show', $blog->id) }}"
                                            class="font-semibold text-gray-900"
                                        >
                                            {{ $blog->title }}
                                        </a>


                                        <div class="mt-2 flex flex-wrap gap-2">

                                            @if($blog->is_published)

                                                <span
                                                    class="rounded-full bg-green-50 px-2 py-1 text-[10px] font-semibold uppercase text-green-700"
                                                >
                                                    Published
                                                </span>

                                            @else

                                                <span
                                                    class="rounded-full bg-yellow-50 px-2 py-1 text-[10px] font-semibold uppercase text-yellow-700"
                                                >
                                                    Draft
                                                </span>

                                            @endif


                                            @if($blog->is_featured)

                                                <span
                                                    class="rounded-full bg-purple-50 px-2 py-1 text-[10px] font-semibold uppercase text-purple-700"
                                                >
                                                    Featured
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>


                                <div class="mt-4 flex items-center justify-between">

                                    <span class="text-xs text-gray-400">
                                        {{ number_format($blog->views) }} views
                                    </span>


                                    <div class="flex gap-2">

                                        <a
                                            href="{{ route('blogs.show', $blog->id) }}"
                                            class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('blogs.edit', $blog->id) }}"
                                            class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white"
                                        >
                                            Edit
                                        </a>


                                        <form
                                            action="{{ route('blogs.destroy', $blog->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this blog post?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>



                    {{-- =====================================================
                        PAGINATION
                    ====================================================== --}}

                    @if($blogs->hasPages())

                        <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">

                            {{ $blogs->links() }}

                        </div>

                    @endif


                @else


                    {{-- =====================================================
                        EMPTY STATE
                    ====================================================== --}}

                    <div class="px-6 py-20 text-center">

                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-8 w-8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V5.625a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                                />
                            </svg>

                        </div>


                        <h3 class="mt-5 text-lg font-semibold text-gray-900">
                            No blog posts found
                        </h3>


                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">

                            @if(request()->hasAny(['search', 'category', 'status']))

                                No articles match your current filters.

                            @else

                                Your Enterblaze blog is ready. Create your first article to get started.

                            @endif

                        </p>


                        @if(request()->hasAny(['search', 'category', 'status']))

                            <a
                                href="{{ route('blogs.index') }}"
                                class="mt-6 inline-flex rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Clear Filters
                            </a>

                        @else

                            <a
                                href="{{ route('blogs.create') }}"
                                class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Create Your First Blog
                            </a>

                        @endif

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>