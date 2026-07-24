
<div class="bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    @if($step !== 1)

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            @include('components.universe.webisodes.webisodes-uploader.webisodes-form-step-'.$step)
        </div>

    @else
        <form method="POST" action="{{ route('webisodes.store', $universe[0]['id'] ?? $universe->id) }}" class="mx-auto max-w-7xl space-y-8">
            @csrf
            <input type="hidden" name="step" value="1">
            <input type="hidden" name="webisode_id" value="{{ $webisode->id ?? null}}">
            <input type="hidden" name="webisode_universe_id" value="{{ $webisode->universe->id ?? null}}">

            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Step 1 of 3</p>
                            <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                                Start Your Web Series
                            </h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                                Add the core details for your Enterblaze web series. You can upload cover art and episodes in the next steps.
                            </p>
                            @if ($errors->any())
                                <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                                    <ul class="space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-5 py-4 text-sm">
                            <p class="font-black text-indigo-700">Series Setup</p>
                            <p class="mt-1 text-gray-600">Info → Cover → Episodes</p>
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
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Series Details</p>
                        <h2 class="mt-3 text-2xl font-black text-gray-950">Basic information</h2>

                        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="webisode_title" class="block text-sm font-bold text-gray-900">Series Title</label>
                                <input type="text" name="webisode_title" id="webisode_title" value="{{ old('webisode_title', $webisode->webisode_title ?? '') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="Ex: Reiden Tapped In: Origins">
                            </div>


                            <div class="sm:col-span-3">
                                <label for="webisode_genre" class="block text-sm font-bold text-gray-900">Genre</label>
                                <input type="text" name="webisode_genre" id="webisode_genre" value="{{ old('webisode_genre', $webisode->webisode_genre ?? '') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="Action, Fantasy, Drama">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="webisode_price" class="block text-sm font-bold text-gray-900">Price</label>
                                <input type="number" name="webisode_price" id="webisode_price" value="{{ old('webisode_price', $webisode->webisode_price ?? '') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="webisode_rating" class="block text-sm font-bold text-gray-900">Audience Rating</label>
                                <select id="webisode_rating" name="webisode_rating" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                                    <option value="everyone" @selected(old('webisode_rating', $webisode->webisode_rating ?? '') === 'everyone')>Everyone</option>
                                    <option value="teen" @selected(old('webisode_rating', $webisode->webisode_rating ?? '') === 'teen')>Teen</option>
                                    <option value="mature" @selected(old('webisode_rating', $webisode->webisode_rating ?? '') === 'mature')>Mature</option>
                                    <option value="adult" @selected(old('webisode_rating', $webisode->webisode_rating ?? '') === 'adult')>Adult</option>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="webisode_release_date" class="block text-sm font-bold text-gray-900">Release date</label>
                                <input type="datetime-local" name="webisode_release_date" id="webisode_release_date" value="{{ old('webisode_release_date', $webisode->webisode_release_date ?? '') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="Action, Fantasy, Drama">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="webisode_status" class="block text-sm font-bold text-gray-900">Status</label>
                                <select id="webisode_status" name="webisode_status" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                                    <option value="draft" @selected(old('webisode_status', $webisode->webisode_status ?? '') === 'draft')>Draft</option>
                                    <option value="coming_soon" @selected(old('webisode_status', $webisode->webisode_status ?? '') === 'coming_soon')>Coming Soon</option>
                                    <option value="published" @selected(old('webisode_status', $webisode->webisode_status ?? '') === 'published')>Published</option>
                                    <option value="featured" @selected(old('webisode_status', $webisode->webisode_status ?? '') === 'featured')>Featured</option>
                                </select>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="webisode_logline" class="block text-sm font-bold text-gray-900">Logline</label>
                                <input type="text" name="webisode_logline" id="webisode_logline" value="{{ old('webisode_logline', $webisode->webisode_logline ?? '') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="One powerful sentence that sells the series.">
                            </div>

                            <div class="sm:col-span-6">
                                <label for="webisode_description" class="block text-sm font-bold text-gray-900">Series Description</label>
                                <textarea id="webisode_description" name="webisode_description" rows="6" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="Give readers a strong reason to start this series.">{{ old('webisode_description', $webisode->webisode_description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-6 space-y-6">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Progress</p>
                            <div class="mt-6 space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-indigo-600 text-sm font-black text-white">1</span>
                                    <div>
                                        <p class="text-sm font-black text-gray-950">Series Info</p>
                                        <p class="text-xs text-gray-500">Title, genre, rating</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 opacity-60">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-sm font-black text-gray-600">2</span>
                                    <div>
                                        <p class="text-sm font-black text-gray-950">Artwork</p>
                                        <p class="text-xs text-gray-500">Cover and banner</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 opacity-60">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-gray-100 text-sm font-black text-gray-600">3</span>
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
                                Keep the logline short and memorable. Think of it like the text viewers see before clicking play.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
                            <section class="border-t border-gray-200 pt-8">
                                <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Webisode Tags</h4>

                                <div class="mt-5">
                                
                                    <div id="tag-container"
                                            class="flex min-h-[56px] flex-wrap items-center gap-2 rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                        <input type="text" id="tag-input"
                                                class="min-w-[180px] flex-1 border-0 bg-transparent px-2 py-1 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                                placeholder="Type a tag and press Enter">
                                    </div>
                                    <input type="hidden" name="webisode_tags" id="event-tags-hidden" value="{{ old('webisode_tags', $webisodes->webisode_tags ?? '') }}">
                                    <p class="mt-2 text-xs text-gray-500">Press Enter or comma after each tag.</p>
                                </div>
                            </section>

            <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('webisodes.index', $universe[0]['id'] ?? $universe->id) }}" class="rounded-2xl border border-gray-300 bg-white px-5 py-3 text-center text-sm font-black text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit" class="rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700">
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
    const hiddenInput = document.getElementById('event-tags-hidden');

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
