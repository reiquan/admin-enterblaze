<x-app-layout>

    {{-- ================================================================
        PAGE HEADER
    ================================================================= --}}

    <div class="border-b border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                        Blog Management
                    </p>

                    <h1 class="mt-2 text-2xl font-black text-gray-900 sm:text-3xl">
                        Edit Blog
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                        Update your article content, publishing settings, media, and SEO information.
                    </p>

                </div>


                <div class="flex flex-wrap gap-2">

                    <a
                        href="{{ route('blogs.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        ← Blogs
                    </a>


                    <a
                        href="{{ route('blogs.show', $blog->id) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-bold text-indigo-700 transition hover:bg-indigo-100"
                    >
                        View Blog
                    </a>

                </div>

            </div>

        </div>

    </div>



    {{-- ================================================================
        PAGE CONTENT
    ================================================================= --}}

    <div class="bg-gray-50 py-8 sm:py-10">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- ========================================================
                SUCCESS MESSAGE
            ========================================================= --}}

            @if(session('success'))

                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4">

                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                            ✓
                        </div>

                        <div>

                            <p class="text-sm font-bold text-green-900">
                                Blog Updated
                            </p>

                            <p class="mt-1 text-sm text-green-700">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                </div>

            @endif



            {{-- ========================================================
                VALIDATION ERRORS
            ========================================================= --}}

            @if($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100 font-black text-red-700">
                            !
                        </div>

                        <div>

                            <p class="text-sm font-bold text-red-900">
                                There are a few things to fix.
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif



            {{-- ========================================================
                MAIN GRID
            ========================================================= --}}

            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">


                {{-- ====================================================
                    EDITOR
                ===================================================== --}}

                <div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">

                        @include('blogs.layouts.blog-post', [
                            'post' => $blog
                        ])

                    </div>

                </div>



                {{-- ====================================================
                    SIDEBAR
                ===================================================== --}}

                <aside class="space-y-6">


                    {{-- BLOG STATUS --}}

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                        <p class="text-xs font-black uppercase tracking-[0.18em] text-gray-400">
                            Current Status
                        </p>

                        <div class="mt-4">

                            @if($blog->is_published)

                                <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1.5 text-xs font-black text-green-700">

                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                    Published

                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-black text-yellow-700">

                                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>

                                    Draft

                                </span>

                            @endif

                        </div>


                        <dl class="mt-5 space-y-4 text-sm">

                            <div class="flex items-center justify-between gap-4">

                                <dt class="text-gray-500">
                                    Created
                                </dt>

                                <dd class="font-semibold text-gray-900">
                                    {{ $blog->created_at->format('M d, Y') }}
                                </dd>

                            </div>


                            <div class="flex items-center justify-between gap-4">

                                <dt class="text-gray-500">
                                    Updated
                                </dt>

                                <dd class="font-semibold text-gray-900">
                                    {{ $blog->updated_at->format('M d, Y') }}
                                </dd>

                            </div>


                            <div class="flex items-center justify-between gap-4">

                                <dt class="text-gray-500">
                                    Views
                                </dt>

                                <dd class="font-semibold text-gray-900">
                                    {{ number_format($blog->views ?? 0) }}
                                </dd>

                            </div>


                            @if($blog->published_at)

                                <div class="flex items-center justify-between gap-4">

                                    <dt class="text-gray-500">
                                        Published
                                    </dt>

                                    <dd class="text-right font-semibold text-gray-900">
                                        {{ $blog->published_at->format('M d, Y') }}
                                    </dd>

                                </div>

                            @endif

                        </dl>

                    </div>



                    {{-- FEATURED IMAGE --}}

                    @if($blog->featured_image)

                        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-100 px-5 py-4">

                                <p class="text-xs font-black uppercase tracking-[0.18em] text-gray-400">
                                    Current Featured Image
                                </p>

                            </div>

                            <img
                                src="{{ Storage::disk('s3-public')->url($blog->featured_image) }}"
                                alt="{{ $blog->title }}"
                                class="aspect-video w-full object-cover"
                            >

                            <div class="p-4">

                                <p class="text-xs leading-5 text-gray-500">
                                    Uploading a new featured image in the editor will replace this image.
                                </p>

                            </div>

                        </div>

                    @endif

                    {{-- FEATURED Video --}}

                    @if($blog->featured_video)

                        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                            <div class="border-b border-gray-100 px-5 py-4">

                                <p class="text-xs font-black uppercase tracking-[0.18em] text-gray-400">
                                    Current Featured Image
                                </p>

                            </div>

                            <img
                                src="{{ Storage::disk('s3-public')->url($blog->featured_video) }}"
                                alt="{{ $blog->title }}"
                                class="aspect-video w-full object-cover"
                            >

                            <div class="p-4">

                                <p class="text-xs leading-5 text-gray-500">
                                    Uploading a new featured image in the editor will replace this image.
                                </p>

                            </div>

                        </div>

                    @endif



                    {{-- ARTICLE INFORMATION --}}

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                        <p class="text-xs font-black uppercase tracking-[0.18em] text-gray-400">
                            Article
                        </p>

                        <h3 class="mt-3 text-lg font-black leading-snug text-gray-900">
                            {{ $blog->title }}
                        </h3>


                        @if($blog->category)

                            <div class="mt-4">

                                <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">
                                    {{ $blog->category }}
                                </span>

                            </div>

                        @endif


                        @if(!empty($blog->tags))

                            <div class="mt-4 flex flex-wrap gap-2">

                                @foreach($blog->tags as $tag)

                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        #{{ $tag }}
                                    </span>

                                @endforeach

                            </div>

                        @endif

                    </div>



                    {{-- DANGER ZONE --}}

                    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                        <p class="text-xs font-black uppercase tracking-[0.18em] text-red-500">
                            Danger Zone
                        </p>

                        <h3 class="mt-2 text-sm font-black text-red-900">
                            Delete Blog
                        </h3>

                        <p class="mt-2 text-xs leading-5 text-red-700">
                            Permanently remove this article and its featured image.
                        </p>


                        <form
                            method="POST"
                            action="{{ route('blogs.destroy', $blog->id) }}"
                            class="mt-4"
                            onsubmit="return confirm('Are you sure you want to permanently delete this blog?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-black text-white transition hover:bg-red-700"
                            >
                                Delete Blog
                            </button>

                        </form>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-app-layout>