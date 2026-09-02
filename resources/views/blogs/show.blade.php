<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        {{-- ============================================================
            HERO / FEATURED IMAGE
        ============================================================= --}}

        <section class="relative overflow-hidden">

            @if($blog->featured_image)

                <div class="relative h-[420px] w-full overflow-hidden sm:h-[520px]">

                    <img
                        src="{{ Storage::disk('s3-public')->url($blog->featured_image) }}"
                        alt="{{ $blog->title }}"
                        class="h-full w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0">

                        <div class="mx-auto max-w-5xl px-6 pb-10 sm:px-8 sm:pb-14">

                            {{-- CATEGORY --}}

                            @if($blog->category)

                                <span class="inline-flex rounded-full bg-red-600 px-3 py-1 text-xs font-black uppercase tracking-[0.18em] text-white">
                                    {{ $blog->category }}
                                </span>

                            @endif


                            <h1 class="mt-4 max-w-4xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                                {{ $blog->title }}
                            </h1>


                            @if($blog->summary)

                                <p class="mt-5 max-w-3xl text-base leading-7 text-gray-200 sm:text-lg">
                                    {{ $blog->summary }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            @else

                <div class="border-b border-gray-200 bg-gradient-to-br from-gray-950 via-gray-900 to-black">

                    <div class="mx-auto max-w-5xl px-6 py-16 sm:px-8 sm:py-24">

                        @if($blog->category)

                            <span class="inline-flex rounded-full bg-red-600 px-3 py-1 text-xs font-black uppercase tracking-[0.18em] text-white">
                                {{ $blog->category }}
                            </span>

                        @endif


                        <h1 class="mt-5 max-w-4xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                            {{ $blog->title }}
                        </h1>


                        @if($blog->summary)

                            <p class="mt-6 max-w-3xl text-base leading-7 text-gray-300 sm:text-lg">
                                {{ $blog->summary }}
                            </p>

                        @endif

                    </div>

                </div>

            @endif

        </section>



        {{-- ============================================================
            ARTICLE
        ============================================================= --}}

        <main class="mx-auto max-w-5xl px-6 py-10 sm:px-8 sm:py-14">

            {{-- ========================================================
                META
            ========================================================= --}}

            <div class="flex flex-col gap-5 border-b border-gray-200 pb-8 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    {{-- AUTHOR PHOTO --}}

                    <div class="h-12 w-12 overflow-hidden rounded-full bg-gray-200">

                        @if($blog->user?->photo_url)

                            <img
                                src="{{ config('filesystems.disks.s3-public.url') . $blog->user->photo_url }}"
                                alt="{{ $blog->user->name }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-black text-white">
                                {{ strtoupper(substr($blog->user?->name ?? 'E', 0, 1)) }}
                            </div>

                        @endif

                    </div>


                    <div>

                        <p class="text-sm font-black text-gray-900">
                            {{ $blog->user?->name ?? 'Enterblaze Editorial' }}
                        </p>

                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">

                            @if($blog->published_at)

                                <span>
                                    {{ $blog->published_at->format('M d, Y') }}
                                </span>

                            @else

                                <span>
                                    {{ $blog->created_at->format('M d, Y') }}
                                </span>

                            @endif

                            <span>•</span>

                            <span>
                                {{ $blog->reading_time }} min read
                            </span>

                            <span>•</span>

                            <span>
                                {{ number_format($blog->views ?? 0) }} views
                            </span>

                        </div>

                    </div>

                </div>



                {{-- ADMIN ACTIONS --}}

                @auth

                    <div class="flex flex-wrap gap-2">

                        <a
                            href="{{ route('blogs.index') }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50"
                        >
                            All Blogs
                        </a>


                        <a
                            href="{{ route('blogs.edit', $blog->id) }}"
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-indigo-700"
                        >
                            Edit Blog
                        </a>

                    </div>

                @endauth

            </div>



            {{-- ========================================================
                ARTICLE CONTENT
            ========================================================= --}}

            <article class="blog-content mx-auto mt-10 max-w-3xl">

                {!! $blog->content !!}

            </article>



            {{-- ========================================================
                TAGS
            ========================================================= --}}

            @if(!empty($blog->tags))

                <div class="mx-auto mt-12 max-w-3xl border-t border-gray-200 pt-8">

                    <p class="mb-4 text-xs font-black uppercase tracking-[0.18em] text-gray-400">
                        Tags
                    </p>

                    <div class="flex flex-wrap gap-2">

                        @foreach($blog->tags as $tag)

                            <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700">
                                #{{ $tag }}
                            </span>

                        @endforeach

                    </div>

                </div>

            @endif



            {{-- ========================================================
                AUTHOR BOX
            ========================================================= --}}

            <div class="mx-auto mt-14 max-w-3xl rounded-2xl border border-gray-200 bg-gray-50 p-6 sm:p-8">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full bg-gray-900">

                        @if($blog->user?->photo_url)

                            <img
                                src="{{ config('filesystems.disks.s3-public.url') . $blog->user->photo_url }}"
                                alt="{{ $blog->user->name }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center text-xl font-black text-white">
                                {{ strtoupper(substr($blog->user?->name ?? 'E', 0, 1)) }}
                            </div>

                        @endif

                    </div>


                    <div>

                        <p class="text-xs font-black uppercase tracking-[0.18em] text-red-600">
                            Written By
                        </p>

                        <h3 class="mt-1 text-xl font-black text-gray-900">
                            {{ $blog->user?->name ?? 'Enterblaze Editorial' }}
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Independent stories, manga culture, creator news, and the latest from Enterblaze.
                        </p>

                    </div>

                </div>

            </div>



            {{-- ========================================================
                BACK TO BLOGS
            ========================================================= --}}

            <div class="mx-auto mt-10 max-w-3xl">

                <a
                    href="{{ route('blogs.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-gray-600 transition hover:text-red-600"
                >
                    <span>
                        ←
                    </span>

                    Back to Blogs
                </a>

            </div>

        </main>

    </div>



    {{-- ================================================================
        BLOG ARTICLE STYLING
    ================================================================= --}}

    <style>

        .blog-content {
            color: #1f2937;
            font-size: 1.075rem;
            line-height: 1.9;
        }


        .blog-content p {
            margin-bottom: 1.5rem;
        }


        .blog-content h1 {
            margin-top: 3rem;
            margin-bottom: 1.25rem;

            font-size: 2.5rem;
            line-height: 1.15;
            font-weight: 900;

            color: #111827;
        }


        .blog-content h2 {
            margin-top: 2.75rem;
            margin-bottom: 1rem;

            font-size: 2rem;
            line-height: 1.2;
            font-weight: 900;

            color: #111827;
        }


        .blog-content h3 {
            margin-top: 2.25rem;
            margin-bottom: .85rem;

            font-size: 1.5rem;
            line-height: 1.3;
            font-weight: 800;

            color: #111827;
        }


        .blog-content strong {
            font-weight: 800;
            color: #111827;
        }


        .blog-content em {
            font-style: italic;
        }


        .blog-content u {
            text-decoration: underline;
        }


        .blog-content ul {
            margin: 1.5rem 0 1.75rem 1.75rem;
            list-style-type: disc;
        }


        .blog-content ol {
            margin: 1.5rem 0 1.75rem 1.75rem;
            list-style-type: decimal;
        }


        .blog-content li {
            margin-bottom: .6rem;
            padding-left: .25rem;
        }


        .blog-content blockquote {
            position: relative;

            margin: 2.5rem 0;

            border-left: 5px solid #dc2626;

            background: #f9fafb;

            padding: 1.5rem 1.75rem;

            font-size: 1.2rem;
            line-height: 1.8;

            font-style: italic;

            color: #374151;
        }


        .blog-content blockquote p:last-child {
            margin-bottom: 0;
        }


        .blog-content a {
            color: #dc2626;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 3px;
        }


        .blog-content a:hover {
            color: #991b1b;
        }


        .blog-content hr {
            margin: 3rem 0;

            border: 0;
            border-top: 1px solid #d1d5db;
        }


        .blog-content img {
            width: 100%;
            height: auto;

            margin: 2.5rem 0;

            border-radius: 1rem;
        }


        .blog-content video {
            width: 100%;

            margin: 2.5rem 0;

            border-radius: 1rem;
        }


        .blog-content iframe {
            width: 100%;

            min-height: 420px;

            margin: 2.5rem 0;

            border: 0;

            border-radius: 1rem;
        }


        @media (max-width: 640px) {

            .blog-content {
                font-size: 1rem;
                line-height: 1.8;
            }


            .blog-content h1 {
                font-size: 2rem;
            }


            .blog-content h2 {
                font-size: 1.65rem;
            }


            .blog-content h3 {
                font-size: 1.3rem;
            }


            .blog-content blockquote {
                padding: 1.25rem;
                font-size: 1.05rem;
            }


            .blog-content iframe {
                min-height: 240px;
            }

        }

    </style>

</x-app-layout>