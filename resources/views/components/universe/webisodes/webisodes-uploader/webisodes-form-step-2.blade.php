<div class="bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
    <form method="POST" action="{{ route('webisodes.store',['universe_id' => $universe->id, 'webisode_id' => $webisode->id]) }}" class="mx-auto max-w-6xl" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">
        <input type="hidden" name="universe_id" value="{{ $universe->id }}">
        <input type="hidden" name="webisode_id" value="{{ $webisode->id }}">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-5.75a.75.75 0 001.5 0v-5a.75.75 0 00-1.5 0v5zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Please fix the following:</h3>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 bg-white px-6 py-5 sm:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium uppercase tracking-wide text-indigo-600">Step {{ $step ?? 2 }}</p>
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Upload Webisode Cover</h1>
                            </div>
                        </div>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                            Add the artwork for this webisode series.
                        </p>
                    </div>

                    <div class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600">
                        Front + Back Cover
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-0 lg:grid-cols-5">
                <aside class="border-b border-gray-200 px-6 py-8 sm:px-8 lg:col-span-2 lg:border-b-0 lg:border-r">
                    <div class="sticky top-6">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Artwork Guidelines</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Upload clean JPG or PNG artwork. Keep important logos, faces, symbols, and text centered so the images still look good when cropped.
                        </p>

                        <div class="mt-6 rounded-xl border border-indigo-100 bg-indigo-50/70 p-4">
                            <div class="flex gap-3">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                                <div>
                                    <h3 class="text-sm font-semibold text-indigo-900">Important</h3>
                                    <p class="mt-1 text-sm leading-6 text-indigo-800">
                                        The upload/replace buttons inside each uploader are forced to act like normal buttons so they do not submit the whole form.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                <span>Webisode image: main artwork shown to users.</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                <span>Submit once after both upload is selected.</span>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="px-6 py-8 sm:px-8 lg:col-span-3">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6zM3.75 15l4.72-4.72a1.5 1.5 0 012.12 0L15 14.69l1.22-1.22a1.5 1.5 0 012.12 0l1.91 1.91" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">Webisode Cover</h3>
                                            <p class="text-sm text-gray-500">Main display artwork.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <br>
                                    <div data-upload-card-zone class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-4 transition hover:border-indigo-300 hover:bg-indigo-50/30">
                                        @livewire('webisode-upload', [
                                            'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id ?? $universe_id,
                                            'webisode_id' => $webisode->id,
                                            'current' => isset($webisode->webisode_cover_image) ? Storage::disk('s3-public')->url($webisode->webisode_cover_image) : null,
                                            'logo' => $webisode->webisode_cover_image ?? '',
                                            'field' => 'webisode_cover_image',
                                            'type' => Route::is('webisodes.edit') ? 'edit' : ''
                                        ], key('webisodes-front-upload-' . ($webisode->id ?? 'new')))
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900">Ready to continue?</h3>
                                    <p class="mt-1 text-sm text-gray-500">Upload both images above, then use this button to submit Step {{ $step ?? 2 }}.</p>
                                </div>

                                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Save Artwork & Continue
                                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-upload-card-zone] button:not([type])').forEach(function (button) {
                button.setAttribute('type', 'button');
            });

            document.querySelectorAll('[data-upload-card-zone] button[type="submit"]').forEach(function (button) {
                button.setAttribute('type', 'button');
            });
        });

        document.addEventListener('livewire:navigated', function () {
            document.querySelectorAll('[data-upload-card-zone] button:not([type])').forEach(function (button) {
                button.setAttribute('type', 'button');
            });

            document.querySelectorAll('[data-upload-card-zone] button[type="submit"]').forEach(function (button) {
                button.setAttribute('type', 'button');
            });
        });
    </script>
</div>
