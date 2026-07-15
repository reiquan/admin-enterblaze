<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    @if($step > 1)

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            @include('components.universe.webisodes.webisode-videos.webisode-videos-uploader.webisode-video-form-step-'.$step)
        </div>

    @else
        <form method="POST"
              action="{{ route('webisode-videos.store', ['universe_id' => $universe->id, 'webisode_id' => $webisode->id]) }}"
              class="mx-auto max-w-7xl space-y-8">

            @csrf

            <input type="hidden" name="step" value="1">
            <input type="hidden" name="webisode_id" value="{{ $webisode->id ?? request('webisode_id') }}">
            <input type="hidden" name="webisode_video_id" value="{{ $webisodeVideo->id ?? null }}">

            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                Step 1 of 3
                            </p>

                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                Add a Webisode Video
                            </h1>

                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                Add the core details for this video. You can upload the video file and thumbnail in the next steps.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-5 py-4 text-sm">
                            <p class="font-black text-indigo-700">Video Setup</p>
                            <p class="mt-1 text-gray-600">Info → Media → Submit</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
                    <h3 class="text-sm font-black text-red-900">This needs attention</h3>

                    <ul class="mt-3 space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>* {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">
                            Video Details
                        </p>

                        <h2 class="mt-3 text-2xl font-black text-gray-950">
                            Basic information
                        </h2>

                        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="video_title" class="block text-sm font-bold text-gray-900">
                                    Video Title
                                </label>

                                <input type="text"
                                       name="video_title"
                                       id="video_title"
                                       value="{{ old('video_title', $webisodeVideo->video_title ?? '') }}"
                                       class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                       placeholder="Ex: Episode 1 - The Awakening">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="video_number" class="block text-sm font-bold text-gray-900">
                                    Video Number
                                </label>

                                <input type="number"
                                       min="1"
                                       name="video_number"
                                       id="video_number"
                                       value="{{ old('video_number', $webisodeVideo->video_number ?? 1) }}"
                                       class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="video_sort_order" class="block text-sm font-bold text-gray-900">
                                    Sort Order
                                </label>

                                <input type="number"
                                       min="0"
                                       name="video_sort_order"
                                       id="video_sort_order"
                                       value="{{ old('video_sort_order', $webisodeVideo->video_sort_order ?? 0) }}"
                                       class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="video_rating" class="block text-sm font-bold text-gray-900">
                                    Audience Rating
                                </label>

                                <select id="video_rating"
                                        name="video_rating"
                                        class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">

                                    <option value="everyone" @selected(old('video_rating', $webisodeVideo->video_rating ?? '') === 'everyone')>
                                        Everyone
                                    </option>

                                    <option value="teen" @selected(old('video_rating', $webisodeVideo->video_rating ?? '') === 'teen')>
                                        Teen
                                    </option>

                                    <option value="mature" @selected(old('video_rating', $webisodeVideo->video_rating ?? '') === 'mature')>
                                        Mature
                                    </option>

                                    <option value="adult" @selected(old('video_rating', $webisodeVideo->video_rating ?? '') === 'adult')>
                                        Adult
                                    </option>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="video_publish_at" class="block text-sm font-bold text-gray-900">
                                    Publish Date
                                </label>

                                <input type="datetime-local"
                                       name="video_publish_at"
                                       id="video_publish_at"
                                       value="{{ old('video_publish_at', isset($webisodeVideo->video_publish_at) ? $webisodeVideo->video_publish_at->format('Y-m-d\TH:i') : '') }}"
                                       class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="video_is_published" class="block text-sm font-bold text-gray-900">
                                    Status
                                </label>

                                <select id="video_is_published"
                                        name="video_is_published"
                                        class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">

                                    <option value="0" @selected((string) old('video_is_published', $webisodeVideo->video_is_published ?? 0) === '0')>
                                        Draft
                                    </option>

                                    <option value="1" @selected((string) old('video_is_published', $webisodeVideo->video_is_published ?? 0) === '1')>
                                        Published
                                    </option>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="video_price" class="block text-sm font-bold text-gray-900">
                                    Price
                                </label>

                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="video_price"
                                       id="video_price"
                                       value="{{ old('video_price', $webisodeVideo->video_price ?? '') }}"
                                       class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                       placeholder="0.00">
                            </div>

                            <div class="sm:col-span-6">
                                <label for="video_description" class="block text-sm font-bold text-gray-900">
                                    Video Description
                                </label>

                                <textarea id="video_description"
                                          name="video_description"
                                          rows="6"
                                          class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm"
                                          placeholder="Describe what happens in this video.">{{ old('video_description', $webisodeVideo->video_description ?? '') }}</textarea>
                            </div>

                            <div class="sm:col-span-6">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <label class="flex items-start gap-3 rounded-2xl border border-gray-200 p-4">
                                        <input type="hidden" name="video_is_free" value="0">

                                        <input type="checkbox"
                                               name="video_is_free"
                                               value="1"
                                               class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                               @checked(old('video_is_free', $webisodeVideo->video_is_free ?? true))>

                                        <div>
                                            <p class="text-sm font-black text-gray-950">Free Video</p>
                                            <p class="mt-1 text-xs text-gray-500">Allow everyone to watch.</p>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 rounded-2xl border border-gray-200 p-4">
                                        <input type="hidden" name="video_is_locked" value="0">

                                        <input type="checkbox"
                                               name="video_is_locked"
                                               value="1"
                                               class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                               @checked(old('video_is_locked', $webisodeVideo->video_is_locked ?? false))>

                                        <div>
                                            <p class="text-sm font-black text-gray-950">Locked</p>
                                            <p class="mt-1 text-xs text-gray-500">Restrict access.</p>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 rounded-2xl border border-gray-200 p-4">
                                        <input type="hidden" name="video_is_featured" value="0">

                                        <input type="checkbox"
                                               name="video_is_featured"
                                               value="1"
                                               class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                               @checked(old('video_is_featured', $webisodeVideo->video_is_featured ?? false))>

                                        <div>
                                            <p class="text-sm font-black text-gray-950">Featured</p>
                                            <p class="mt-1 text-xs text-gray-500">Promote this video.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <section class="mt-8 border-t border-gray-200 pt-8">
                            <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">
                                Video Tags
                            </h4>

                            <div class="mt-5">
                                <div id="tag-container"
                                     class="flex min-h-[56px] flex-wrap items-center gap-2 rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">

                                    <input type="text"
                                           id="tag-input"
                                           class="min-w-[180px] flex-1 border-0 bg-transparent px-2 py-1 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                           placeholder="Type a tag and press Enter">
                                </div>

                                <input type="hidden"
                                       name="video_tags"
                                       id="video-tags-hidden"
                                       value="{{ old('video_tags', isset($webisodeVideo->video_tags) ? json_encode($webisodeVideo->video_tags) : '') }}">

                                <p class="mt-2 text-xs text-gray-500">
                                    Press Enter or comma after each tag.
                                </p>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-6 space-y-6">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                                Progress
                            </p>

                            <div class="mt-6 space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-indigo-600 text-sm font-black text-white">
                                        1
                                    </span>

                                    <div>
                                        <p class="text-sm font-black text-gray-950">Video Info</p>
                                        <p class="text-xs text-gray-500">Title, number, description</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 opacity-60">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-sm font-black text-gray-600">
                                        2
                                    </span>

                                    <div>
                                        <p class="text-sm font-black text-gray-950">Media</p>
                                        <p class="text-xs text-gray-500">Video and thumbnail</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 opacity-60">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-sm font-black text-gray-600">
                                        3
                                    </span>

                                    <div>
                                        <p class="text-sm font-black text-gray-950">Submit</p>
                                        <p class="text-xs text-gray-500">Review and finish</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6 shadow-sm">
                            <p class="text-sm font-black text-indigo-800">Creator Tip</p>

                            <p class="mt-2 text-sm leading-6 text-gray-700">
                                Use a clear episode title and short description so viewers know exactly what to expect before pressing play.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('webisodes.show',  ['universe_id' => $universe->id, 'webisode_id' => $webisode->id]) }}"
                   class="rounded-2xl border border-gray-300 bg-white px-5 py-3 text-center text-sm font-black text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                        class="rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700">
                    Save & Continue
                </button>
            </div>
        </form>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tagInput = document.getElementById('tag-input');
    const tagContainer = document.getElementById('tag-container');
    const hiddenInput = document.getElementById('video-tags-hidden');

    if (!tagInput || !tagContainer || !hiddenInput) {
        return;
    }

    let tags = [];

    try {
        const startingValue = hiddenInput.value;

        if (startingValue) {
            const parsed = JSON.parse(startingValue);
            tags = Array.isArray(parsed) ? parsed : [];
        }
    } catch (error) {
        tags = hiddenInput.value
            ? hiddenInput.value.split(',').map(tag => tag.trim()).filter(Boolean)
            : [];
    }

    function syncTags() {
        hiddenInput.value = JSON.stringify(tags);
    }

    function renderTags() {
        tagContainer.querySelectorAll('[data-tag-pill]').forEach(tag => tag.remove());

        tags.forEach((tagText, index) => {
            const pill = document.createElement('span');

            pill.dataset.tagPill = 'true';
            pill.className = 'inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 ring-1 ring-inset ring-indigo-100';

            const label = document.createElement('span');
            label.textContent = tagText;

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'text-indigo-400 hover:text-red-500';
            button.innerHTML = '&times;';

            button.addEventListener('click', () => {
                tags.splice(index, 1);
                renderTags();
            });

            pill.appendChild(label);
            pill.appendChild(button);

            tagContainer.insertBefore(pill, tagInput);
        });

        syncTags();
    }

    tagInput.addEventListener('keydown', event => {
        if (event.key !== 'Enter' && event.key !== ',') {
            return;
        }

        event.preventDefault();

        const value = tagInput.value.trim();
        const normalizedValue = value.toLowerCase();

        if (!value || tags.some(tag => tag.toLowerCase() === normalizedValue)) {
            tagInput.value = '';
            return;
        }

        tags.push(value);
        tagInput.value = '';

        renderTags();
    });

    renderTags();
});
</script>
