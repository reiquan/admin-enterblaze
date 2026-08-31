
<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-red-50">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="grid gap-8 lg:grid-cols-12">


                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}

                <main class="lg:col-span-9 xl:col-span-9">

                    {{-- Page Header --}}
                    <div class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-red-600">
                                    Enterblaze Blog
                                </p>

                                <h1 class="mt-2 text-3xl font-black tracking-tight text-gray-900 sm:text-4xl">
                                    Create A Blog
                                </h1>

                                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                                    Create your article, upload media, organize your content,
                                    and prepare it for publishing.
                                </p>

                            </div>


                            <a
                                href="{{ route('blogs.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                            >
                                Back To Blogs
                            </a>

                        </div>

                    </div>


                    {{-- =====================================================
                        VALIDATION ERRORS
                    ====================================================== --}}

                    @if($errors->any())

                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">

                            <div class="flex items-start gap-3">

                                <div class="mt-0.5 text-red-600">

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
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-semibold text-red-800">
                                        Please fix the following:
                                    </p>

                                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">

                                        @foreach($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =====================================================
                        BLOG EDITOR
                    ====================================================== --}}

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">

                            <div class="flex items-center justify-between">

                                <div>

                                    <h2 class="text-base font-bold text-gray-900">
                                        Blog Editor
                                    </h2>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Add your article information and media below.
                                    </p>

                                </div>


                                <span
                                    class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700"
                                >
                                    Draft
                                </span>

                            </div>

                        </div>


                        <div class="p-5 sm:p-7">

                            @include('blogs.layouts.blog-post')

                        </div>

                    </div>

                </main>

            </div>

        </div>

    </div>



    {{-- =========================================================
        FEATURED IMAGE PREVIEW
    ========================================================== --}}

    <script>
        /*
        |--------------------------------------------------------------------------
        | IMAGE PREVIEW
        |--------------------------------------------------------------------------
        |
        | Keeps your existing imgInp / prview functionality intact.
        |
        */

        const imgInp = document.getElementById('imgInp');
        const prview = document.getElementById('prview');

        if (imgInp && prview) {

            imgInp.onchange = evt => {

                const [file] = imgInp.files;

                if (file) {

                    prview.style.visibility = 'visible';

                    prview.src = URL.createObjectURL(file);

                }

            };

        }
    </script>



    {{-- =========================================================
        VIDEO PREVIEW
    ========================================================== --}}

    <script>
        /*
        |--------------------------------------------------------------------------
        | VIDEO PREVIEW
        |--------------------------------------------------------------------------
        |
        | Keeps your existing featured_video / vupld functionality intact.
        |
        */

        const videoUpload =
            document.getElementById('featured_video');

        const vupld =
            document.getElementById('vupld');


        if (videoUpload) {

            videoUpload.onchange = function(event) {

                if (vupld) {
                    vupld.style.visibility = 'visible';
                }


                const file =
                    event.target.files[0];


                if (!file) {
                    return;
                }


                const blobURL =
                    URL.createObjectURL(file);


                /*
                 * Prefer the preview video associated
                 * with #vupld if one exists.
                 */

                const video =
                    vupld
                        ? vupld.querySelector('video')
                        : document.querySelector('video');


                if (video) {

                    video.src = blobURL;

                    video.load();

                }

            };

        }
    </script>

    </x-app-layout>
