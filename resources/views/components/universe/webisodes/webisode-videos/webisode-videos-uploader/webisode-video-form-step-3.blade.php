<div class="bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
    <form method="POST"
          action="{{ route('webisode-videos.store', [
                'universe_id' => $universe->id,
              'webisode_id' => $webisode->id,
              'webisode_video_id' => $webisodeVideo->id
          ]) }}"
          class="mx-auto max-w-7xl space-y-8">
        @csrf

        <input type="hidden" name="step" value="{{ $step ?? 3 }}">
        <input type="hidden" name="webisode_id" value="{{ $webisode->id }}">
        <input type="hidden" name="webisode_video_id" value="{{ $webisodeVideo->id }}">

        @if ($errors->any())
            <div class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <h3 class="text-sm font-black text-red-900">Please fix the following</h3>
                <ul class="mt-2 space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 sm:p-8 lg:p-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Step {{ $step ?? 3 }} of 3</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">Review & Submit Video</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                            Review the episode details, uploaded media, pricing, and access settings before finishing.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-5 py-4 text-sm">
                        <p class="font-black text-indigo-700">Final Review</p>
                        <p class="mt-1 text-gray-600">Info → Media → Submit</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            <div class="space-y-8 lg:col-span-8">
                <section class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-5 sm:px-8">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Episode Preview</p>
                                <h2 class="mt-2 text-2xl font-black text-gray-950">{{ $webisodeVideo->video_title ?? 'Untitled Video' }}</h2>
                            </div>

                            <a href="{{ route('webisode-videos.create',  [
                                            'universe_id' => $universe->id,
                                        'webisode_id' => $webisode->id,
                                        'webisode_video_id' => $webisodeVideo->id,
                                        'step' => 1
                                    ]) }}"
                               class="rounded-2xl border border-gray-300 bg-white px-4 py-2 text-sm font-black text-gray-700 hover:bg-gray-50">
                                Edit Details
                            </a>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        @if(!empty($webisodeVideo->video_path))
                            <div class="overflow-hidden rounded-3xl bg-black">
                                <video controls
                                       preload="metadata"
                                       poster="{{ !empty($webisodeVideo->video_thumbnail) ? Storage::disk('s3-public')->url($webisodeVideo->video_thumbnail) : '' }}"
                                       class="aspect-video w-full bg-black object-contain">
                                    <source src="{{ Storage::disk('s3-public')->url($webisodeVideo->video_path) }}"
                                            type="{{ $webisodeVideo->video_mime_type ?? 'video/mp4' }}">
                                    Your browser does not support HTML video.
                                </video>
                            </div>
                        @else
                            <div class="flex aspect-video items-center justify-center rounded-3xl border-2 border-dashed border-gray-300 bg-gray-50 text-center">
                                <div>
                                    <p class="text-sm font-black text-gray-700">No video uploaded</p>
                                    <p class="mt-1 text-xs text-gray-500">Return to Step 2 to upload a video.</p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Episode</p>
                                <p class="mt-2 text-lg font-black text-gray-950">{{ $webisodeVideo->video_number ?? 1 }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Duration</p>
                                <p class="mt-2 text-lg font-black text-gray-950">
                                    @if(!empty($webisodeVideo->video_duration_seconds))
                                        {{ gmdate($webisodeVideo->video_duration_seconds >= 3600 ? 'H:i:s' : 'i:s', $webisodeVideo->video_duration_seconds) }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Rating</p>
                                <p class="mt-2 text-lg font-black capitalize text-gray-950">{{ $webisodeVideo->video_rating ?? 'Not set' }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">File Size</p>
                                <p class="mt-2 text-lg font-black text-gray-950">
                                    @if(!empty($webisodeVideo->video_file_size))
                                        {{ number_format($webisodeVideo->video_file_size / 1024 / 1024, 2) }} MB
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Video Information</p>
                            <h2 class="mt-2 text-2xl font-black text-gray-950">Episode details</h2>
                        </div>

                        <a href="{{ route('webisode-videos.create',  [
                                            'universe_id' => $universe->id,
                                        'webisode_id' => $webisode->id,
                                        'video_id' => $webisodeVideo->id,
                                    ]) }}"
                           class="text-sm font-black text-indigo-600 hover:text-indigo-500">
                            Edit information
                        </a>
                    </div>

                    <dl class="mt-8 divide-y divide-gray-200">
                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-3">
                            <dt class="text-sm font-black text-gray-500">Title</dt>
                            <dd class="text-sm font-bold text-gray-950 sm:col-span-2">{{ $webisodeVideo->video_title ?? 'Untitled Video' }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-3">
                            <dt class="text-sm font-black text-gray-500">Description</dt>
                            <dd class="whitespace-pre-line text-sm leading-6 text-gray-700 sm:col-span-2">
                                {{ $webisodeVideo->video_description ?: 'No description added.' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-3">
                            <dt class="text-sm font-black text-gray-500">Publish date</dt>
                            <dd class="text-sm text-gray-700 sm:col-span-2">
                                {{ $webisodeVideo->video_publish_at?->format('M j, Y \a\t g:i A') ?? 'Publish immediately or leave as draft' }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-3">
                            <dt class="text-sm font-black text-gray-500">Tags</dt>
                            <dd class="sm:col-span-2">
                                @if(!empty($webisodeVideo->video_tags))
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($webisodeVideo->video_tags as $tag)
                                            <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-black text-indigo-700 ring-1 ring-inset ring-indigo-100">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">No tags added.</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Media Files</p>
                            <h2 class="mt-2 text-2xl font-black text-gray-950">Video and thumbnail</h2>
                        </div>

                        <a href="{{ route('webisode-videos.create',  [
                                            'universe_id' => $universe->id,
                                        'webisode_id' => $webisode->id,
                                        'video_id' => $webisodeVideo->id,
                                        'step' => 2
                                    ]) }}"
                           class="text-sm font-black text-indigo-600 hover:text-indigo-500">
                            Replace media
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-black text-gray-950">Video File</p>
                            <p class="mt-4 truncate text-sm font-black text-gray-900">{{ basename($webisodeVideo->video_path ?? 'No video uploaded') }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $webisodeVideo->video_mime_type ?? 'File type unavailable' }}</p>
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-black text-gray-950">Thumbnail</p>

                            <div class="mt-4 overflow-hidden rounded-2xl border border-gray-200 bg-white">
                                @if(!empty($webisodeVideo->video_thumbnail))
                                    <img src="{{ Storage::disk('s3-public')->url($webisodeVideo->video_thumbnail) }}"
                                         alt="{{ $webisodeVideo->video_title }} thumbnail"
                                         class="aspect-video w-full object-cover">
                                @else
                                    <div class="flex aspect-video items-center justify-center text-xs font-bold text-gray-400">No thumbnail uploaded</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="lg:col-span-4">
                <div class="sticky top-6 space-y-6">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Publishing Summary</p>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Status</span>
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $webisodeVideo->video_is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $webisodeVideo->video_is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Free access</span>
                                <span class="text-sm font-black text-gray-950">{{ $webisodeVideo->video_is_free ? 'Yes' : 'No' }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Locked</span>
                                <span class="text-sm font-black text-gray-950">{{ $webisodeVideo->video_is_locked ? 'Yes' : 'No' }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Featured</span>
                                <span class="text-sm font-black text-gray-950">{{ $webisodeVideo->video_is_featured ? 'Yes' : 'No' }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Price</span>
                                <span class="text-sm font-black text-gray-950">${{ number_format($webisodeVideo->video_price ?? 0, 2) }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-bold text-gray-600">Blaze Tokens</span>
                                <span class="text-sm font-black text-gray-950">{{ number_format($webisodeVideo->video_blaze_token_cost ?? 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6 shadow-sm">
                        <p class="text-sm font-black text-indigo-900">Final checklist</p>

                        <div class="mt-4 space-y-3 text-sm text-indigo-800">
                            <div class="flex gap-3"><span class="font-black">✓</span><span>Video is five minutes or shorter.</span></div>
                            <div class="flex gap-3"><span class="font-black">✓</span><span>Thumbnail and video preview correctly.</span></div>
                            <div class="flex gap-3"><span class="font-black">✓</span><span>Title, rating, and access settings are correct.</span></div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3.5 text-sm font-black text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Submit & Finish Video
                        </button>

                        <a href="{{ route('webisode-videos.create',  [
                                            'universe_id' => $universe->id,
                                        'webisode_id' => $webisode->id,
                                        'webisode_video_id' => $webisodeVideo->id,
                                        'step' => 2
                                    ]) }}"
                           class="mt-3 inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-black text-gray-700 hover:bg-gray-50">
                            Back to Media
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>
