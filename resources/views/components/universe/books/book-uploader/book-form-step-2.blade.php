<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">

        <div class="mx-auto max-w-7xl space-y-8">
            {{-- Header --}}
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Book Setup</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                            Upload Your Book Cover
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                            Add the cover art readers will see across Enterblaze. Use a clean JPG, PNG, or WEBP file with a proper file extension.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-5 py-4 text-sm">
                        <p class="font-black text-indigo-700">Step {{ $step ?? 2 }}</p>
                        <p class="mt-1 text-gray-600">Cover Image</p>
                    </div>
                </div>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                    <div class="flex gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-100 text-red-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-5.75a.75.75 0 001.5 0v-5.5a.75.75 0 00-1.5 0v5.5zM10 15.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-red-900">Upload needs attention</h3>
                            <ul class="mt-2 space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>* {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Upload Area --}}
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="mb-6 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Cover Upload</p>
                                <h2 class="mt-3 text-2xl font-black text-gray-950">Select your cover file</h2>
                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    Recommended format: vertical cover art, JPG / JPEG / PNG / WEBP, under your Livewire upload max size.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 p-6">
                            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                                @if( Route::is('books.edit') )
                                    @livewire('book-cover-upload', [
                                        'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                        'book_id' => $book->id,
                                        'current' => isset($book->book_image_path) ? Storage::disk('s3-public')->url($book->book_image_path) : null,
                                        'logo' => $book->book_image_path ?? '',
                                        'type' => 'edit'
                                    ])
                                @else
                                    @livewire('book-cover-upload', [
                                        'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                        'book_id' => $book->id,
                                        'current' => '',
                                        'logo' => $book->book_image_path ?? '',
                                        'type' => ''
                                    ])
                                @endif
                                @if(isset($book->book_image_path) && $book->book_image_path)

                                        <div class="mt-6 flex flex-wrap gap-4">

                                            <form action="{{ route('books.index', [
                                                'universe_id' => $_REQUEST['universe_id'],
                                                'book_id' => $book->id
                                            ]) }}" method="GET">

                                                <input type="hidden" name="step" value="3">

                                                <button
                                                    type="submit"
                                                    class="rounded-2xl border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                                                    Keep Existing Cover & Continue
                                                </button>

                                            </form>

                                        </div>

                                    @endif
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Allowed</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">JPG, JPEG, PNG, WEBP</p>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Best Shape</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">Vertical Cover</p>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Tip</p>
                                <p class="mt-2 text-sm font-bold text-gray-900">Rename file first</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="sticky top-6 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Preview</p>
                                <h2 class="mt-3 text-2xl font-black text-gray-950">Current Cover</h2>
                            </div>

                            @if(isset($book->book_image_path) && $book->book_image_path)
                                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700 ring-1 ring-green-200">Uploaded</span>
                            @else
                                <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-700 ring-1 ring-orange-200">Missing</span>
                            @endif
                        </div>

                        <div class="mt-6 overflow-hidden rounded-3xl border border-gray-200 bg-gray-100">
                            @if(isset($book->book_image_path) && $book->book_image_path)
                                <a href="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" target="_blank">
                                    <img src="{{ Storage::disk('s3-public')->url($book->book_image_path) }}" alt="{{ $book->book_title ?? 'Book cover' }}" class="aspect-[4/5] w-full object-cover">
                                </a>
                            @else
                                <div class="flex aspect-[4/5] w-full items-center justify-center p-8 text-center">
                                    <div>
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-sm font-black text-gray-900">No cover uploaded yet</p>
                                        <p class="mt-2 text-sm text-gray-500">Your uploaded cover will preview here.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-4 text-sm leading-6 text-gray-700">
                            <p class="font-black text-indigo-800">Fix for Livewire preview error</p>
                            <p class="mt-1">Make sure the uploaded image has a real extension like <strong>.jpg</strong>, <strong>.png</strong>, or <strong>.webp</strong>. Files with no extension can trigger the temporary preview MIME error.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{--
Livewire upload configuration reminder:
In config/livewire.php, make sure temporary_file_upload.preview_mimes includes:
'jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg'

In your BookCoverUpload Livewire component, validate the file like:
'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'

In the component's file input, use:
accept="image/jpeg,image/jpg,image/png,image/webp"
--}}
