<div class="min-h-[70vh] bg-slate-100 px-4 py-8 sm:px-6 lg:px-8">
    <form method="POST" action="" class="mx-auto max-w-7xl">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.5a.75.75 0 00-1.5 0v4.25a.75.75 0 001.5 0V6.5zM10 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">Please fix the following</h3>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-800 px-6 py-8 sm:px-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-300">Universe Builder</p>
                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-white sm:text-3xl">Upload Universe Profile Image</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                            Add the main visual identity for this universe. This image will help users recognize the world, story, or collection inside your admin.
                        </p>
                    </div>

                    <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-slate-200 shadow-sm backdrop-blur">
                        <span class="font-semibold text-white">Step {{ $step }}</span>
                        <span class="text-slate-400">/ Profile Setup</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 p-6 sm:p-8 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-950">Upload image</h2>
                                <p class="text-sm text-slate-500">Recommended: square image, PNG/JPG, clear logo or cover art.</p>
                            </div>
                        </div>

                        <div class="mt-6 rounded-xl border border-dashed border-slate-300 bg-white p-4">
                            @if( Route::is('universe.edit') )
                                @livewire('profile-upload', [
                                    'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                    'logo' => $universe->universe_logo ?? '',
                                    'type' => 'edit'
                                ])
                            @else
                                @livewire('profile-upload', [
                                    'universe_id' => isset($_REQUEST['universe_id']) ? $_REQUEST['universe_id'] : $universe->id,
                                    'logo' => $universe->universe_logo ?? '',
                                    'type' => ''
                                ])
                            @endif
                        </div>

                        <div class="mt-5 grid gap-3 text-sm text-slate-600 sm:grid-cols-2">
                            <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                                <p class="font-semibold text-slate-900">Best size</p>
                                <p class="mt-1">1024 × 1024px or larger</p>
                            </div>
                            <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                                <p class="font-semibold text-slate-900">Best use</p>
                                <p class="mt-1">Logo, crest, or key artwork</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5 flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-950">Current image preview</h2>
                                <p class="text-sm text-slate-500">This is how the universe image currently appears.</p>
                            </div>

                            @if(isset($universe->universe_logo))
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Uploaded</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-200">Needs image</span>
                            @endif
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-950">
                            @if(isset($universe->universe_logo))
                                <img
                                    src="{{ Storage::disk('s3-public')->url($universe->universe_logo) }}"
                                    alt="Universe profile image"
                                    class="aspect-video h-full w-full object-cover object-center"
                                >
                            @else
                                <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-8 text-center">
                                    <div>
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15">
                                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-base font-semibold text-white">No image uploaded yet</h3>
                                        <p class="mt-2 max-w-md text-sm leading-6 text-slate-300">
                                            Upload a profile image to replace this placeholder and complete this section of the universe setup.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 rounded-xl border border-indigo-100 bg-indigo-50 p-4 text-sm text-indigo-800">
                            <p class="font-semibold">Admin tip</p>
                            <p class="mt-1">Use a clean, high-contrast image so the universe stays readable in cards, tables, and mobile views.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
