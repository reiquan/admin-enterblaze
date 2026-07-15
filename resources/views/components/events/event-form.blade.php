@php
    $currentStep = (int) ($step ?? request('step', 1));
    $eventModel = $event ?? null;

    $livestreamModel = $eventModel?->livestream;

    $inputClass = 'block w-full rounded-2xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500';
    $labelClass = 'mb-2 block text-sm font-bold text-gray-700';
@endphp

<div class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.28em] text-indigo-600">Event Builder</p>
                <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950">
                    {{ isset($eventModel->id) ? 'Edit Event' : 'Create Event' }}
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                    Build your event details, location, schedule, tags, and publishing settings from one clean admin flow.
                </p>
            </div>

            <a href="{{ route('events.index') }}"
               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">
                Back to Events
            </a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2">
            @foreach([1 => 'Event Info', 2 => 'Event Picture'] as $stepNumber => $stepTitle)
                @php $isActive = $currentStep === $stepNumber; @endphp

                @if(isset($eventModel->id))
                    <form method="GET" action="{{ route('events.edit', $eventModel->id) }}">
                        <input type="hidden" name="step" value="{{ $stepNumber }}">
                        <input type="hidden" name="event_id" value="{{ $eventModel->id }}">
                        <button type="submit"
                                class="w-full rounded-3xl border p-5 text-left transition {{ $isActive ? 'border-indigo-200 bg-indigo-50 shadow-sm' : 'border-gray-200 bg-white hover:bg-gray-50' }}">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl text-sm font-black {{ $isActive ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }}">
                                {{ $stepNumber }}
                            </span>
                            <span class="ml-3 text-sm font-black {{ $isActive ? 'text-indigo-700' : 'text-gray-700' }}">
                                Step {{ $stepNumber }} - {{ $stepTitle }}
                            </span>
                        </button>
                    </form>
                @else
                    <div class="rounded-3xl border p-5 {{ $isActive ? 'border-indigo-200 bg-indigo-50 shadow-sm' : 'border-gray-200 bg-white opacity-70' }}">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl text-sm font-black {{ $isActive ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }}">
                            {{ $stepNumber }}
                        </span>
                        <span class="ml-3 text-sm font-black {{ $isActive ? 'text-indigo-700' : 'text-gray-700' }}">
                            Step {{ $stepNumber }} - {{ $stepTitle }}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="bg-gray-50 px-6 py-8 lg:px-8">
    <div class="mx-auto max-w-7xl">
        @if($currentStep > 1)
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm lg:p-8">
                @include('components.events.event-form-step-'.$currentStep)
            </div>
        @else
            @if($eventModel)
                <form method="POST" action="{{ route('events.update', ['event_id' => $eventModel->id, 'step' => 1]) }}" x-data="{
                    eventType: @js(old('event_type', $eventModel->event_type ?? ''))
                }" class="space-y-8">
            @else
                <form method="POST" action="{{ route('events.update') }}" x-data="{
                    eventType: @js(old('event_type', $eventModel->event_type ?? ''))
                }" class="space-y-8">
                    <input type="hidden" name="step" value="1">
            @endif
                @csrf

                <div class="grid gap-8 lg:grid-cols-12">
                    <aside class="lg:col-span-4">
                        <div class="sticky top-6 space-y-6">
                            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">Setup</p>
                                <h2 class="mt-2 text-xl font-black text-gray-950">Event Settings</h2>
                                <p class="mt-3 text-sm leading-6 text-gray-500">
                                    Start with the essentials: name, price, audience, venue, schedule, and searchable tags.
                                </p>
                            </div>

                            <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                                <p class="text-sm font-black text-indigo-900">Admin Tip</p>
                                <p class="mt-2 text-sm leading-6 text-indigo-700">
                                    Use short tags like <span class="font-bold">anime</span>, <span class="font-bold">vendors</span>, <span class="font-bold">tournament</span>, or <span class="font-bold">family-friendly</span> so events are easier to filter later.
                                </p>
                            </div>
                        </div>
                    </aside>

                    <main class="lg:col-span-8">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm lg:p-8">
                            <div class="border-b border-gray-200 pb-6">
                                <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">Step 1</p>
                                <h3 class="mt-2 text-2xl font-black text-gray-950">Event Information</h3>
                                <p class="mt-2 text-sm text-gray-500">Fill out the event profile visitors will see.</p>
                            </div>

                            <div class="mt-8 space-y-10">
                                <section>
                                    <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Basic Details</h4>

                                    <div class="mt-5 grid gap-6 md:grid-cols-2">
                                        <div class="md:col-span-2">
                                            <label for="event_name" class="{{ $labelClass }}">Event Name</label>
                                            <input type="text" name="event_name" id="event_name" required
                                                   value="{{ old('event_name', $eventModel->event_name ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="Eebee Con 2027">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="subtitle" class="{{ $labelClass }}">Event Subtitle</label>
                                            <input type="text" name="subtitle" id="subtitle" required
                                                   value="{{ old('subtitle', $eventModel->subtitle ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="A new wave of anime, comics, manga, and creators">
                                        </div>

                                        <div>
                                            <label for="event_price" class="{{ $labelClass }}">Event Price</label>
                                            <input type="number" name="price" id="event_price" required min="0" step="0.01"
                                                   value="{{ old('price', $eventModel->price ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="10.00">
                                        </div>

                                        <div>
                                            <label for="event_type" class="{{ $labelClass }}">Event Type</label>
                                            <select id="event_type"
                                                    name="event_type"
                                                    x-model="eventType"
                                                    class="{{ $inputClass }}">
                                                <option value="">Select event type</option>
                                                @foreach(['Tradeshow', 'Online Tournament', 'Registration', 'Livestream'] as $type)
                                                    <option value="{{ $type }}" @selected(old('event_type', $eventModel->event_type ?? '') === $type)>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="event_audience" class="{{ $labelClass }}">Audience</label>
                                            <select id="event_audience" name="event_audience" class="{{ $inputClass }}">
                                                <option value="">Select audience</option>
                                                @foreach(['All Ages', 'Adults Only', 'NSFW'] as $audience)
                                                    <option value="{{ $audience }}" @selected(old('event_audience', $eventModel->event_audience ?? '') === $audience)>{{ $audience }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="event_about" class="{{ $labelClass }}">Event Description</label>
                                            <textarea rows="6" name="event_about" id="event_about"
                                                      class="{{ $inputClass }} resize-none"
                                                      placeholder="What is your event about?">{{ old('event_about', $eventModel->event_about ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </section>

                                <section
                                    x-show="eventType === 'Livestream'"
                                    x-cloak
                                    x-transition.opacity.duration.200ms
                                    class="border-t border-gray-200 pt-8"
                                >
                                    <div class="rounded-3xl border border-purple-200 bg-purple-50/70 p-6">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                            <div>
                                                <p class="text-xs font-black uppercase tracking-[0.2em] text-purple-600">
                                                    Twitch Setup
                                                </p>

                                                <h4 class="mt-2 text-xl font-black text-gray-950">
                                                    Livestream Configuration
                                                </h4>

                                                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                                                    Enterblaze will use these settings to update your Twitch channel and display the broadcast on the event page.
                                                </p>
                                            </div>

                                            <span class="inline-flex w-fit items-center rounded-full bg-purple-600 px-3 py-1.5 text-xs font-black uppercase tracking-wider text-white">
                                                Twitch
                                            </span>
                                        </div>

                                        <input
                                            type="hidden"
                                            name="event_livestream_platform"
                                            value="twitch"
                                            x-bind:disabled="eventType !== 'Livestream'"
                                        >

                                        <div class="mt-6 space-y-6">
                                            <div>
                                                <label for="event_livestream_title" class="{{ $labelClass }}">
                                                    Twitch Stream Title
                                                </label>

                                                <input
                                                    type="text"
                                                    id="event_livestream_title"
                                                    name="event_livestream_title"
                                                    value="{{ old(
                                                        'event_livestream_title',
                                                        $livestreamModel->event_livestream_title
                                                            ?? $eventModel->event_name
                                                            ?? ''
                                                    ) }}"
                                                    maxlength="140"
                                                    x-bind:disabled="eventType !== 'Livestream'"
                                                    class="{{ $inputClass }}"
                                                    placeholder="Enter the title viewers will see on Twitch"
                                                >

                                                <p class="mt-2 text-xs leading-5 text-gray-500">
                                                    This value maps to the event_livestream_title column and can be sent to Twitch when the event is saved or synchronized.
                                                </p>
                                            </div>

                                            <div>
                                                <label for="event_livestream_category_id" class="{{ $labelClass }}">
                                                    Twitch Category
                                                </label>

                                                <select
                                                    id="event_livestream_category_id"
                                                    name="event_livestream_category_id"
                                                    x-bind:disabled="eventType !== 'Livestream'"
                                                    class="{{ $inputClass }}"
                                                >
                                                    <option value="">Select a Twitch category</option>

                                                    @foreach($twitchCategories ?? [] as $category)
                                                        <option
                                                            value="{{ $category['id'] }}"
                                                            @selected(
                                                                old(
                                                                    'event_livestream_category_id',
                                                                    $livestreamModel->event_livestream_category_id ?? ''
                                                                ) == $category['id']
                                                            )
                                                        >
                                                            {{ $category['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if(empty($twitchCategories))
                                                    <p class="mt-2 text-xs leading-5 text-amber-700">
                                                        No Twitch categories were loaded. Pass a $twitchCategories array to this view from your controller.
                                                    </p>
                                                @else
                                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                                        Choose the Twitch game or content category that best matches this event.
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="rounded-2xl border border-purple-200 bg-white p-5">
                                                <p class="text-sm font-black text-purple-950">
                                                    How the broadcast works
                                                </p>

                                                <p class="mt-2 text-sm leading-6 text-purple-800">
                                                    Saving the event prepares the Twitch metadata. At the scheduled time, start OBS using your Twitch stream key. The Enterblaze event page can then embed your live Twitch channel automatically.
                                                </p>
                                            </div>

                                            @if(!empty($livestreamModel?->event_livestream_schedule_segment_id))
                                                <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4">
                                                    <p class="text-sm font-black text-blue-900">
                                                        Twitch schedule segment connected
                                                    </p>

                                                    <p class="mt-1 break-all text-xs text-blue-700">
                                                        {{ $livestreamModel->event_livestream_schedule_segment_id }}
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($livestreamModel?->event_livestream_status))
                                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                                                    <p class="text-sm font-black text-emerald-900">
                                                        Twitch synchronization status
                                                    </p>

                                                    <p class="mt-1 text-sm text-emerald-700">
                                                        {{ $livestreamModel->event_livestream_status }}
                                                        @if(!empty($livestreamModel?->event_livestream_synced_at))
                                                            <span class="block pt-1 text-xs">
                                                                Last synced:
                                                                {{ $livestreamModel->event_livestream_synced_at->format('M j, Y g:i A') }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif

                                            @if(!empty($livestreamModel?->event_livestream_error))
                                                <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                                                    <p class="text-sm font-black text-red-900">
                                                        Twitch synchronization error
                                                    </p>

                                                    <p class="mt-1 text-sm leading-6 text-red-700">
                                                        {{ $livestreamModel->event_livestream_error }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </section>

                                <section class="border-t border-gray-200 pt-8">
                                    <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Venue & Location</h4>

                                    <div class="mt-5 grid gap-6 md:grid-cols-2">
                                        <div class="md:col-span-2">
                                            <label for="venue" class="{{ $labelClass }}">Venue Name</label>
                                            <input type="text" name="venue" id="venue" required
                                                   value="{{ old('venue', $eventModel->venue ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="University of Advancing Technology">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="event_address_line_1" class="{{ $labelClass }}">Address Line 1</label>
                                            <input type="text" name="event_address_line_1" id="event_address_line_1" required
                                                   value="{{ old('event_address_line_1', $eventModel->event_address_line_1 ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="2625 W Baseline Rd">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="event_address_line_2" class="{{ $labelClass }}">Address Line 2</label>
                                            <input type="text" name="event_address_line_2" id="event_address_line_2"
                                                   value="{{ old('event_address_line_2', $eventModel->event_address_line_2 ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="Suite, room, booth area, etc.">
                                        </div>

                                        <div>
                                            <label for="event_city" class="{{ $labelClass }}">City</label>
                                            <input type="text" name="event_city" id="event_city" required
                                                   value="{{ old('event_city', $eventModel->event_city ?? '') }}"
                                                   class="{{ $inputClass }}" placeholder="Tempe">
                                        </div>

                                        <div class="grid gap-6 sm:grid-cols-2">
                                            <div>
                                                <label for="event_state" class="{{ $labelClass }}">State</label>
                                                <input type="text" name="event_state" id="event_state" required
                                                       value="{{ old('event_state', $eventModel->event_state ?? '') }}"
                                                       class="{{ $inputClass }}" placeholder="AZ">
                                            </div>

                                            <div>
                                                <label for="event_zip" class="{{ $labelClass }}">Zip</label>
                                                <input type="text" name="event_zip" id="event_zip" required
                                                       value="{{ old('event_zip', $eventModel->event_zip ?? '') }}"
                                                       class="{{ $inputClass }}" placeholder="85283">
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section class="border-t border-gray-200 pt-8">
                                    <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Schedule</h4>

                                    <div class="mt-5 grid gap-6 md:grid-cols-2">
                                        <div>
                                            <label for="event_start_date" class="{{ $labelClass }}">
                                                Start Date
                                                @if(!empty($eventModel->event_start_date))
                                                    <span class="ml-2 text-xs font-semibold text-emerald-600">Current: {{ $eventModel->event_start_date }}</span>
                                                @endif
                                            </label>
                                            <input name="event_start_date" id="event_start_date" type="datetime-local"
                                                   value="{{ old('event_start_date') }}"
                                                   class="{{ $inputClass }}" @required(empty($eventModel->event_start_date))>
                                        </div>

                                        <div>
                                            <label for="event_end_date" class="{{ $labelClass }}">
                                                End Date
                                                @if(!empty($eventModel->event_end_date))
                                                    <span class="ml-2 text-xs font-semibold text-emerald-600">Current: {{ $eventModel->event_end_date }}</span>
                                                @endif
                                            </label>
                                            <input name="event_end_date" id="event_end_date" type="datetime-local"
                                                   value="{{ old('event_end_date') }}"
                                                   class="{{ $inputClass }}" @required(empty($eventModel->event_end_date))>
                                        </div>
                                    </div>
                                </section>

                                <section class="border-t border-gray-200 pt-8">
                                    <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Tags</h4>

                                    <div class="mt-5">
                                        <label for="tag-input" class="{{ $labelClass }}">Event Tags</label>
                                        <div id="tag-container"
                                             class="flex min-h-[56px] flex-wrap items-center gap-2 rounded-2xl border border-gray-300 bg-white px-3 py-3 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                            <input type="text" id="tag-input"
                                                   class="min-w-[180px] flex-1 border-0 bg-transparent px-2 py-1 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                                   placeholder="Type a tag and press Enter">
                                        </div>
                                        <input type="hidden" name="event_tags" id="event-tags-hidden" value="{{ old('event_tags', $eventModel->event_tags ?? '') }}">
                                        <p class="mt-2 text-xs text-gray-500">Press Enter or comma after each tag.</p>
                                    </div>
                                </section>

                                @if(auth()->user()->current_team_id == 1)
                                    <section class="border-t border-gray-200 pt-8">
                                        <h4 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400">Admin Event Category</h4>

                                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                            <label class="flex cursor-pointer gap-4 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm transition hover:bg-gray-50">
                                                <input type="radio" name="is_election_event" value="1"
                                                       class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                       @checked(old('is_election_event', $eventModel->is_election_event ?? '') == 1)>
                                                <span>
                                                    <span class="block text-sm font-black text-gray-900">Election Event</span>
                                                    <span class="mt-1 block text-xs leading-5 text-gray-500">Mark this as election related.</span>
                                                </span>
                                            </label>

                                            <label class="flex cursor-pointer gap-4 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm transition hover:bg-gray-50">
                                                <input type="radio" name="is_election_event" value="0"
                                                       class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                       @checked(old('is_election_event', $eventModel->is_election_event ?? '') === 0 || old('is_election_event', $eventModel->is_election_event ?? '') === '0')>
                                                <span>
                                                    <span class="block text-sm font-black text-gray-900">Non-Election Event</span>
                                                    <span class="mt-1 block text-xs leading-5 text-gray-500">Standard creator, comic, tournament, or livestream event.</span>
                                                </span>
                                            </label>
                                        </div>
                                    </section>
                                @endif
                            </div>

                            <div class="mt-10 flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end">
                                <a href="{{ route('events.index') }}"
                                   class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">
                                    Cancel
                                </a>

                                <button type="submit" name="type" value="{{ Route::is('events.edit') ? 'edit' : '' }}"
                                        class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700">
                                    {{ isset($eventModel) && !empty($eventModel?->toArray()) ? 'Update Event' : 'Save Event' }}
                                </button>
                            </div>
                        </div>
                    </main>
                </div>
            </form>
        @endif
    </div>
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
