<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">

        <div class="mx-auto max-w-7xl space-y-8">
            {{-- Header --}}
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Chapter Setup</p>
                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                Upload Your Chapter Cover
                            </h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                Add the cover image readers will see before opening this chapter. Use a clean vertical JPG, PNG, or WEBP file.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-5 py-4 text-sm">
                            <p class="font-black text-indigo-700">Step {{ $step ?? 2 }}</p>
                            <p class="mt-1 text-gray-600">Chapter Cover</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-red-900">Upload needs attention</h3>
                    <ul class="mt-3 space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>* {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                {{-- Upload Card --}}
                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Upload</p>
                                <h2 class="mt-3 text-2xl font-black text-gray-950">Select chapter cover art</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    This image should represent the chapter at a glance and fit your book’s visual style.
                                </p>
                            </div>

                            @if(isset($issue->issue_image_cover) && $issue->issue_image_cover)
                                <span class="inline-flex w-fit rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700 ring-1 ring-green-200">
                                    Current Cover Found
                                </span>
                            @else
                                <span class="inline-flex w-fit rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-700 ring-1 ring-orange-200">
                                    Missing Cover
                                </span>
                            @endif
                        </div>

                        <div class="mt-8 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 p-5">
                            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                                @if( Route::is('issues.edit') )
                                    @livewire('issue-covers-upload', [
                                        'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                        'book_id' => $issue->book->id,
                                        'issue_id' => $issue->id,
                                        'current' => isset($issue->issue_image_cover) && $issue->issue_image_cover ? Storage::disk('s3-public')->url($issue->issue_image_cover) : null,
                                        'logo' => $issue->issue_image_cover ?? '',
                                        'type' => 'edit'
                                    ])
                                @else
                                    @livewire('issue-covers-upload', [
                                        'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                        'book_id' => $issue->book->id,
                                        'issue_id' => $issue->id,
                                        'current' => '',
                                        'logo' => $issue->issue_image_cover ?? '',
                                        'type' => ''
                                    ])
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Allowed</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">JPG, PNG, WEBP</p>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Shape</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">Vertical Cover</p>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Tip</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">Use real extension</p>
                            </div>
                        </div>

                        @if(isset($issue->issue_image_cover) && $issue->issue_image_cover)
                            <div class="mt-6 rounded-3xl border border-indigo-100 bg-indigo-50 p-5">
                                <p class="text-sm font-black text-indigo-800">Already have a chapter cover?</p>
                                <p class="mt-1 text-sm leading-6 text-gray-700">
                                    You can keep the current cover and move forward without uploading another image.
                                </p>

                                <div class="mt-4 flex flex-wrap gap-3">
                                    <a href="{{ route('issues.edit', [
                                            'universe_id' => $issue->book->universe->id,
                                            'book_id' => $issue->book->id,
                                            'issue_id' => $issue->id,
                                            'step' => 3
                                        ]) }}"
                                       class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-500">
                                        Skip This Step
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Preview Card --}}
                <div class="lg:col-span-5">
                    <div class="sticky top-6 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Preview</p>
                            <h2 class="mt-3 text-2xl font-black text-gray-950">Current Chapter Cover</h2>
                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                This is the image currently attached to this chapter.
                            </p>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-3xl border border-gray-200 bg-gray-100">
                            @if(isset($issue->issue_image_cover) && $issue->issue_image_cover)
                                <a href="{{ Storage::disk('s3-public')->url($issue->issue_image_cover) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3-public')->url($issue->issue_image_cover) }}"
                                         alt="{{ $issue->issue_title ?? 'Chapter cover' }}"
                                         class="aspect-[4/5] w-full object-cover">
                                </a>
                            @else
                                <div class="flex aspect-[4/5] w-full items-center justify-center p-8 text-center">
                                    <div>
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-sm font-black text-gray-900">No cover uploaded yet</p>
                                        <p class="mt-2 text-sm text-gray-500">Your uploaded chapter cover will show here.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-sm font-black text-gray-900">Upload note</p>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                If Livewire throws a preview MIME error, rename the image with a real extension like .jpg, .png, or .webp.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
