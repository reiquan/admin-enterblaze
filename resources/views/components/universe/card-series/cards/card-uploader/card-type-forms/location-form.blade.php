<form method="post" action="{{ route('cards.updateCardLocation', ['universe_id' => $universe_id ?? $universe->id, 'card_series_id' => $card_series_id, 'card_id' => $card->id]) }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="step" value="3">
    <input type="hidden" name="card_location_universe_id" value="{{ $universe_id ?? $universe->id }}">
    <input type="hidden" name="card_location_id" value="{{ $card->card_location_id ?? null }}">

    <input type="hidden" name="card_id" value="{{ $card->id }}">

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-6 w-6 flex-none items-center justify-center rounded-full bg-red-100 text-sm font-bold">
                    !
                </div>
                <div>
                    <h3 class="text-sm font-semibold">Please fix the following:</h3>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-12">
    
        @include('components.universe.card-series.cards.preview')

        <section class="lg:col-span-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $card->card_name }}
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                    {{ $card->card_bio }}
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-7 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="card_location_name" class="block text-sm font-semibold text-gray-900">
                           Location Nickname
                        </label>
                        <div class="mt-2">
                            <input type="text"
                                    name="card_location_name"
                                    value="{{  $card->location->card_location_name ?? old('card_location_name') }}"
                                    id="card_location_name"
                                    autocomplete="card_location_name"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    placeholder="Example: Reiden Tapped In">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="card_location_region" class="block text-sm font-semibold text-gray-900">
                         Region
                        </label>
                        <div class="mt-2">
                            <input type="text"
                            name="card_location_region"
                            value="{{ $card->location->card_location_region ?? old('card_location_region') }}"
                            id="card_location_region"
                            autocomplete="card_location_region"
                            value="{{ old('card_location_region') }}"
                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                            >
                        </div>
                    </div>
                </div>
                @include('components.universe.card-series.cards.card-uploader.card-type-forms.environment-selection')
                    @php
                   
                        $inputClass = 'block w-full rounded-2xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500';
                        $labelClass = 'mb-2 block text-sm font-bold text-gray-700';
                    @endphp

                    <section class="border-t border-gray-200 pt-8">
                        <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Tags</h4>

                        <div class="mt-5">
                            <label for="tag-input" class="{{ $labelClass }}">Location Effects</label>
                            <div id="tag-container"
                                    class="flex min-h-[56px] flex-wrap items-center gap-2 rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                <input type="text" id="tag-input"
                                        class="min-w-[180px] flex-1 border-0 bg-transparent px-2 py-1 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                        placeholder="Type a tag and press Enter">
                            </div>
                            <input type="hidden" name="card_location_bonuses" id="event-tags-hidden" value="{{ old('card_location_bonuses', $location->bonuses ?? '') }}">
                            <p class="mt-2 text-xs text-gray-500">Press Enter or comma after each tag.</p>
                        </div>
                    </section>


                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('cards.index',['universe_id' => $universe_id ?? $universe->id, 'card_series_id' => $card_series_id]) }}"
                        class="inline-flex justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Save and Continue
                    </button>
                </div>
            </div>
        </section>
    </div>
</form>
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
