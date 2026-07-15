<div class="bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
    <form
        id="webisode-video-media-form"
        method="POST"
       
        action="{{ route('webisode-videos.update', [
            'universe_id' => $universe->id,
            'webisode_id' => $webisode->id,
            'webisode_video_id' => $webisodeVideo->id ?? null
        ]) }}"
        class="mx-auto max-w-6xl"
        enctype="multipart/form-data"
    >
        @csrf

        <input type="hidden" name="step" value="{{ $step ?? 2 }}">
        <input type="hidden" name="webisode_id" value="{{ $webisode->id }}">
        <input type="hidden" name="webisode_video_id" value="{{ $webisodeVideo->id ?? null }}">
        <input
            type="hidden"
            name="video_duration_seconds"
            id="video_duration_seconds"
            value="{{ old('video_duration_seconds', $webisodeVideo->video_duration_seconds ?? '') }}"
        >

        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16Zm-.75-5.75a.75.75 0 001.5 0v-5a.75.75 0 00-1.5 0v5ZM10 15a1 1 0 100-2 1 1 0 000 2Z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-sm font-black text-red-900">Please fix the following</h3>

                        <ul class="mt-2 space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div
            id="client-video-error"
            class="mb-6 hidden rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm"
        >
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16Zm-.75-5.75a.75.75 0 001.5 0v-5a.75.75 0 00-1.5 0v5ZM10 15a1 1 0 100-2 1 1 0 000 2Z" clip-rule="evenodd"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm font-black text-red-900">Video uplsdsddsdoad error</h3>
                    <p id="client-video-error-message" class="mt-1 text-sm text-red-700"></p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 bg-white px-6 py-6 sm:px-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-2.36a.75.75 0 0 1 1.08.67v6.38a.75.75 0 0 1-1.08.67l-4.72-2.36m-10.5 4.5h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.25 6h-9a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 5.25 18Z"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                    Step {{ $step ?? 2 }} of 3
                                </p>

                                <h1 class="mt-1 text-2xl font-black tracking-tight text-gray-950">
                                    Upload Video & Thumbnail
                                </h1>
                            </div>
                        </div>

                        <p class="mt-4 max-w-2xl text-sm leading-6 text-gray-600">
                            Add the video file and thumbnail for
                            <span class="font-black text-gray-900">
                                {{ $webisodeVideo->video_title ?? 'this episode' }}
                            </span>.
                            Videos must be five minutes or shorter.
                        </p>
                    </div>

                    <div class="rounded-full border border-indigo-100 bg-indigo-50 px-4 py-2 text-sm font-black text-indigo-700">
                        Maximum duration: 5:00
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5">
                <aside class="border-b border-gray-200 px-6 py-8 sm:px-8 lg:col-span-2 lg:border-b-0 lg:border-r">
                    <div class="sticky top-6">
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                            Upload Guidelines
                        </p>

                        <h2 class="mt-3 text-xl font-black text-gray-950">
                            Prepare your episode media
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Upload a clean video file and a strong thumbnail. The thumbnail will be used throughout the Enterblaze video library.
                        </p>

                        <div class="mt-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
                            <p class="text-sm font-black text-indigo-900">Video requirements</p>

                            <div class="mt-4 space-y-3 text-sm text-indigo-800">
                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-indigo-500"></span>
                                    <span>Maximum video duration: 5 minutes.</span>
                                </div>

                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-indigo-500"></span>
                                    <span>Accepted formats: MP4, MOV, WebM, and M4V.</span>
                                </div>

                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-indigo-500"></span>
                                    <span>Recommended format: MP4 using H.264 video.</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-5">
                            <p class="text-sm font-black text-gray-900">Thumbnail recommendations</p>

                            <div class="mt-4 space-y-3 text-sm text-gray-600">
                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-gray-400"></span>
                                    <span>Use a 16:9 image.</span>
                                </div>

                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-gray-400"></span>
                                    <span>Recommended size: 1280 × 720 pixels.</span>
                                </div>

                                <div class="flex gap-3">
                                    <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-gray-400"></span>
                                    <span>Accepted formats: JPG, PNG, and WebP.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="px-6 py-8 sm:px-8 lg:col-span-3">
                    <div class="space-y-6">
                        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-2.36a.75.75 0 0 1 1.08.67v6.38a.75.75 0 0 1-1.08.67l-4.72-2.36m-10.5 4.5h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.25 6h-9a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 5.25 18Z"/>
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-base font-black text-gray-950">Episode Video</h3>
                                    <p class="mt-1 text-sm text-gray-500">Upload one video no longer than five minutes.</p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <label
                                    for="video_file"
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center transition hover:border-indigo-400 hover:bg-indigo-50/40"
                                >
                                    <svg class="h-10 w-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5h10.5A2.25 2.25 0 0 0 19.5 17.25V6.75A2.25 2.25 0 0 0 17.25 4.5H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5A2.25 2.25 0 0 0 6.75 19.5Z"/>
                                    </svg>

                                    <span class="mt-4 text-sm font-black text-gray-900">
                                        Choose video file
                                    </span>

                                    <span class="mt-1 text-xs text-gray-500">
                                        MP4, MOV, WebM, or M4V
                                    </span>
                                </label>

                                <input
                                    type="file"
                                    name="video_file"
                                    id="video_file"
                                    accept="video/mp4,video/quicktime,video/webm,video/x-m4v"
                                    class="sr-only"
                                >

                                <div id="video-file-details" class="mt-4 hidden rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <p id="video-file-name" class="truncate text-sm font-black text-gray-900"></p>
                                            <p id="video-file-duration" class="mt-1 text-xs text-gray-500"></p>
                                        </div>

                                        <button
                                            type="button"
                                            id="remove-video-file"
                                            class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-black text-red-700 hover:bg-red-100"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-base font-black text-gray-950">Video Thumbnail</h3>
                                    <p class="mt-1 text-sm text-gray-500">Upload the image viewers will see before pressing play.</p>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-[1fr_220px] md:items-center">
                                <label
                                    for="video_thumbnail"
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center transition hover:border-indigo-400 hover:bg-indigo-50/40"
                                >
                                    <svg class="h-9 w-9 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
                                    </svg>

                                    <span class="mt-3 text-sm font-black text-gray-900">
                                        Choose thumbnail
                                    </span>

                                    <span class="mt-1 text-xs text-gray-500">
                                        JPG, PNG, or WebP
                                    </span>
                                </label>

                                <input
                                    type="file"
                                    name="video_thumbnail"
                                    id="video_thumbnail"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="sr-only"
                                >

                                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
                                    <div id="thumbnail-empty-state" class="flex aspect-video items-center justify-center px-5 text-center">
                                        <span class="text-xs font-bold text-gray-400">Thumbnail preview</span>
                                    </div>

                                    <img
                                        id="thumbnail-preview"
                                        src=""
                                        alt="Selected thumbnail preview"
                                        class="hidden aspect-video w-full object-cover"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-base font-black text-gray-950">Ready to continue?</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Upload the video and thumbnail, then continue to the final review.
                                    </p>
                                </div>

                                <button
                                    type="submit"
                                    id="submit-media-step"
                                    class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Save Media & Continue

                                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
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
            const form = document.getElementById('webisode-video-media-form');
            const videoInput = document.getElementById('video_file');
            const durationInput = document.getElementById('video_duration_seconds');
            const errorBox = document.getElementById('client-video-error');
            const errorMessage = document.getElementById('client-video-error-message');

            const videoDetails = document.getElementById('video-file-details');
            const videoFileName = document.getElementById('video-file-name');
            const videoFileDuration = document.getElementById('video-file-duration');
            const removeVideoButton = document.getElementById('remove-video-file');

            const thumbnailInput = document.getElementById('video_thumbnail');
            const thumbnailPreview = document.getElementById('thumbnail-preview');
            const thumbnailEmptyState = document.getElementById('thumbnail-empty-state');

            let videoIsValid = false;
            const maximumDuration = 300;

            function showVideoError(message) {
                errorMessage.textContent = message;
                errorBox.classList.remove('hidden');
                errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function clearVideoError() {
                errorMessage.textContent = '';
                errorBox.classList.add('hidden');
            }

            function formatDuration(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);

                return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            function resetVideoInput() {
                videoInput.value = '';
                durationInput.value = '';
                videoIsValid = false;

                videoDetails.classList.add('hidden');
                videoFileName.textContent = '';
                videoFileDuration.textContent = '';
            }

            videoInput.addEventListener('change', function () {
                clearVideoError();

                const file = videoInput.files[0];

                if (!file) {
                    resetVideoInput();
                    return;
                }

                const objectUrl = URL.createObjectURL(file);
                const video = document.createElement('video');

                video.preload = 'metadata';

                video.onloadedmetadata = function () {
                    URL.revokeObjectURL(objectUrl);

                    const duration = Math.ceil(video.duration);

                    if (!Number.isFinite(duration)) {
                        resetVideoInput();
                        showVideoError('The selected video duration could not be read. Please choose another video.');
                        return;
                    }

                    if (duration > maximumDuration) {
                        resetVideoInput();
                        showVideoError(
                            `The selected video is ${formatDuration(duration)} long. Videos cannot be longer than 5:00.`
                        );
                        return;
                    }

                    durationInput.value = duration;
                    videoIsValid = true;

                    videoFileName.textContent = file.name;
                    videoFileDuration.textContent = `Duration: ${formatDuration(duration)} · ${(file.size / 1024 / 1024).toFixed(2)} MB`;
                    videoDetails.classList.remove('hidden');
                };

                video.onerror = function () {
                    URL.revokeObjectURL(objectUrl);
                    resetVideoInput();
                    showVideoError('The selected video could not be opened. Please use MP4, MOV, WebM, or M4V.');
                };

                video.src = objectUrl;
            });

            removeVideoButton.addEventListener('click', function () {
                resetVideoInput();
                clearVideoError();
            });

            thumbnailInput.addEventListener('change', function () {
                const file = thumbnailInput.files[0];

                if (!file) {
                    thumbnailPreview.src = '';
                    thumbnailPreview.classList.add('hidden');
                    thumbnailEmptyState.classList.remove('hidden');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    thumbnailPreview.src = event.target.result;
                    thumbnailPreview.classList.remove('hidden');
                    thumbnailEmptyState.classList.add('hidden');
                };

                reader.readAsDataURL(file);
            });

            form.addEventListener('submit', function (event) {
                clearVideoError();

                if (videoInput.files.length > 0 && !videoIsValid) {
                    event.preventDefault();
                    showVideoError('Please wait for the video to finish validating before continuing.');
                    return;
                }

                if (Number(durationInput.value) > maximumDuration) {
                    event.preventDefault();
                    showVideoError('Videos cannot be longer than five minutes.');
                }
            });
        });
    </script>
</div>
