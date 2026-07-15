
        <div class="flex flex-col gap-3 m-12 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Webisode Management</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-gray-950">
                    {{ $webisode->webisode_title ?? 'Webisode Details' }}
                </h2>
            </div>

            <div class="flex flex-wrap gap-3">
                @if(Route::has('webisodes.edit'))
                    <a href="{{ route('webisodes.edit', [
                        'universe_id' => $webisode->webisode_universe_id ?? request('webisode_universe_id'),
                        'webisode_id' => $webisode->id
                    ]) }}"
                       class="rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm hover:bg-gray-50">
                        Edit Webisode
                    </a>
                @endif

                @if(Route::has('webisode-videos.create'))
                    <a href="{{ route('webisode-videos.create', [
                        'universe_id' => $webisode->webisode_universe_id ?? request('universe_id'),
                        'webisode_id' => $webisode->id
                    ]) }}"
                       class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-500">
                        Upload New Video
                    </a>
                @endif
            </div>
        </div>


    @php
        $videos = $webisode->videos ?? collect();

        $coverPath = $webisode->webisode_cover_image ?? null;
        $bannerPath = $webisode->webisode_banner_image ?? null;

        $coverUrl = $coverPath ? Storage::disk('s3-public')->url($coverPath) : null;
        $bannerUrl = $bannerPath ? Storage::disk('s3-public')->url($bannerPath) : null;

        $publishedVideos = $videos->where('video_is_published', true)->count();
        $lockedVideos = $videos->where('video_is_locked', true)->count();
        $totalViews = $videos->sum('video_view_count');
    @endphp

    <div class="bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <section class="relative overflow-hidden rounded-3xl border border-gray-200 bg-gray-950 shadow-sm">
                @if($bannerUrl)
                    <img src="{{ $bannerUrl }}"
                         alt="{{ $webisode->webisode_title ?? 'Webisode banner' }}"
                         class="absolute inset-0 h-full w-full object-cover">
                @endif

                <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-950/85 to-gray-950/40"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent"></div>

                <div class="relative grid min-h-[420px] gap-8 p-6 sm:p-8 lg:grid-cols-[220px_1fr] lg:items-end lg:p-10">
                    <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-2xl">
                        @if($coverUrl)
                            <img src="{{ $coverUrl }}"
                                 alt="{{ $webisode->webisode_title ?? 'Webisode cover' }}"
                                 class="aspect-[4/5] w-full object-cover">
                        @else
                            <div class="flex aspect-[4/5] items-center justify-center bg-white/10 p-8 text-center text-white">
                                <div>
                                    <svg class="mx-auto h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="m15.75 10.5 4.72-2.36a.75.75 0 0 1 1.08.67v6.38a.75.75 0 0 1-1.08.67l-4.72-2.36m-10.5 4.5h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.25 6h-9a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 5.25 18Z"/>
                                    </svg>
                                    <p class="mt-4 text-sm font-black">No cover uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="max-w-3xl">
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-black uppercase tracking-widest text-indigo-200 ring-1 ring-indigo-300/30">
                                Webisode
                            </span>

                            <span class="rounded-full px-3 py-1 text-xs font-black uppercase tracking-widest
                                {{ ($webisode->webisode_is_published ?? false)
                                    ? 'bg-green-500/20 text-green-200 ring-1 ring-green-300/30'
                                    : 'bg-orange-500/20 text-orange-200 ring-1 ring-orange-300/30' }}">
                                {{ ($webisode->webisode_is_published ?? false) ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <h1 class="mt-5 text-4xl font-black tracking-tight text-white sm:text-5xl">
                            {{ $webisode->webisode_title ?? 'Untitled Webisode' }}
                        </h1>

                        <p class="mt-4 text-sm font-bold text-gray-300">
                            Created by {{ $webisode->webisode_creator ?? auth()->user()->name ?? 'Enterblaze Creator' }}
                        </p>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-gray-300 sm:text-base">
                            {{ $webisode->webisode_description
                                ?? $webisode->webisode_short_description
                                ?? 'No description has been added yet.' }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Total Videos</p>
                    <p class="mt-3 text-3xl font-black text-gray-950">{{ number_format($videos->count()) }}</p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Published</p>
                    <p class="mt-3 text-3xl font-black text-gray-950">{{ number_format($publishedVideos) }}</p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Locked</p>
                    <p class="mt-3 text-3xl font-black text-gray-950">{{ number_format($lockedVideos) }}</p>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Total Views</p>
                    <p class="mt-3 text-3xl font-black text-gray-950">{{ number_format($totalViews) }}</p>
                </div>
            </section>

            <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Video Library</p>
                        <h2 class="mt-3 text-2xl font-black text-gray-950">Uploaded Videos</h2>
                        <p class="mt-2 text-sm text-gray-600">Manage all videos connected to this webisode.</p>
                    </div>

                    <span class="w-fit rounded-full bg-gray-100 px-4 py-2 text-xs font-black uppercase tracking-widest text-gray-600 ring-1 ring-gray-200">
                        {{ $videos->count() }} {{ Str::plural('video', $videos->count()) }}
                    </span>
                </div>

                @if($videos->isNotEmpty())
                    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                        @foreach($videos as $video)
                            @php
                                $videoPath = $video->video_path ?? $video->webisode_video_path ?? null;
                                $thumbnailPath = $video->video_thumbnail ?? $video->webisode_video_thumbnail ?? null;

                                $videoUrl = $videoPath
                                    ? Storage::disk('s3-public')->url($videoPath)
                                    : null;

                                $thumbnailUrl = $thumbnailPath
                                    ? Storage::disk('s3-public')->url($thumbnailPath)
                                    : null;
                            @endphp

                            <article class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                <div class="relative bg-gray-950">
                                    @if($videoUrl)
                                        <video controls
                                               preload="metadata"
                                               class="aspect-video w-full bg-black object-contain"
                                               @if($thumbnailUrl) poster="{{ $thumbnailUrl }}" @endif>
                                            <source src="{{ $videoUrl }}"
                                                    type="{{ $video->video_mime_type ?? 'video/mp4' }}">
                                        </video>
                                    @elseif($thumbnailUrl)
                                        <img src="{{ $thumbnailUrl }}"
                                             alt="{{ $video->video_title ?? 'Video thumbnail' }}"
                                             class="aspect-video w-full object-cover">
                                    @else
                                        <div class="flex aspect-video items-center justify-center bg-gray-900 p-8 text-white">
                                            No video uploaded
                                        </div>
                                    @endif

                                    <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-gray-950/80 px-3 py-1 text-xs font-black text-white backdrop-blur">
                                            Video {{ $video->video_number ?? $loop->iteration }}
                                        </span>

                                        <span class="rounded-full px-3 py-1 text-xs font-black text-white
                                            {{ ($video->video_is_published ?? false) ? 'bg-green-600' : 'bg-orange-500' }}">
                                            {{ ($video->video_is_published ?? false) ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                                Video {{ $video->video_number ?? $loop->iteration }}
                                            </p>

                                            <h3 class="mt-2 text-xl font-black text-gray-950">
                                                {{ $video->video_title ?? 'Untitled Video' }}
                                            </h3>
                                        </div>

                                        <span class="rounded-full px-3 py-1 text-xs font-black
                                            {{ ($video->video_is_locked ?? false)
                                                ? 'bg-red-50 text-red-700 ring-1 ring-red-200'
                                                : 'bg-green-50 text-green-700 ring-1 ring-green-200' }}">
                                            {{ ($video->video_is_locked ?? false) ? 'Locked' : 'Unlocked' }}
                                        </span>
                                    </div>

                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $video->video_description ?? 'No video description has been added.' }}
                                    </p>

                                    <div class="mt-5 flex flex-wrap gap-4 text-xs font-bold text-gray-500">
                                        <span>{{ number_format($video->video_view_count ?? 0) }} views</span>

                                        @if(isset($video->created_at))
                                            <span>{{ $video->created_at->format('M j, Y') }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-6 flex flex-wrap gap-3">
                                        @if(Route::has('webisode-videos.show'))
                                            <a href="{{ route('webisode-videos.show', [
                                                'universe_id' => $webisode->universe_id ?? request('universe_id'),
                                                'webisode_id' => $webisode->id,
                                                'video_id' => $video->id
                                            ]) }}"
                                               class="rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-black text-white hover:bg-indigo-500">
                                                View
                                            </a>
                                        @endif

                                        @if(Route::has('webisode-videos.edit'))
                                            <a href="{{ route('webisode-videos.edit', [
                                                'universe_id' => $webisode->universe_id ?? request('universe_id'),
                                                'webisode_id' => $webisode->id,
                                                'video_id' => $video->id
                                            ]) }}"
                                               class="rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-black text-gray-700 hover:bg-gray-50">
                                                Edit
                                            </a>
                                        @endif

                                        <button type="button"
                                                onclick="confirmDelete('{{ $video->id }}')"
                                                class="rounded-2xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-black text-red-700 hover:bg-red-100">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 p-10 text-center">
                        <h3 class="text-xl font-black text-gray-950">No videos uploaded yet</h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-600">
                            Upload the first video to begin building this webisode's video library.
                        </p>

                        @if(Route::has('webisode-videos.create'))
                            <a href="{{ route('webisode-videos.create', [
                                'universe_id' => $webisode->universe_id ?? request('universe_id'),
                                'webisode_id' => $webisode->id
                            ]) }}"
                               class="mt-6 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white hover:bg-indigo-500">
                                Upload First Video
                            </a>
                        @endif
                    </div>
                @endif
            </section>
        </div>
    </div>
