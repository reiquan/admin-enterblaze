<form method="post" action="{{ route('cards.updateCardTier', ['universe_id' => $universe_id ?? $universe->id, 'card_series_id' => $card_series_id, 'card_id' => $card->id]) }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="step" value="3">
    <input type="hidden" name="card_character_universe_id" value="{{ $universe_id ?? $universe->id }}">
    <input type="hidden" name="card_character_id" value="{{ $card->character->id ?? null }}">

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
                        <label for="card_character_name" class="block text-sm font-semibold text-gray-900">
                            Chracter Full Name
                        </label>
                        <div class="mt-2">
                            <input type="text"
                                    name="card_character_name"
                                    value="{{ $card->character->card_character_name ?? old('card_character_name') }}"
                                    id="card_character_name"
                                    autocomplete="card_character_name"
                                    value="{{ old('card_character_name') }}"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    placeholder="Example: Reiden Tapped In">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="card_character_alias" class="block text-sm font-semibold text-gray-900">
                          Alias
                        </label>
                        <div class="mt-2">
                            <input type="text"
                            name="card_character_alias"
                            value="{{ $card->character->card_character_alias ?? old('card_character_alias') }}"
                            id="card_character_alias"
                            autocomplete="card_character_alias"
                            value="{{ old('card_character_alias') }}"
                            class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                            >
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="card_character_age" class="block text-sm font-semibold text-gray-900">
                           Age
                        </label>
                        <div class="mt-2">
                            <input type="number"
                                    name="card_character_age"
                                    value="{{ $card->character->card_character_age ?? old('card_character_age') }}"
                                    id="card_character_age"
                                    autocomplete="card_character_age"
                                    value="{{ old('card_character_age') }}"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    >
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="card_character_race" class="block text-sm font-semibold text-gray-900">
                           Race
                        </label>
                        <div class="mt-2">
                            <input type="text"
                                    name="card_character_race"
                                    value="{{ $card->character->card_character_race ?? old('card_character_race') }}"
                                    id="card_character_race"
                                    autocomplete="card_character_race"
                                    value="{{ old('card_character_race') }}"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    >
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="card_character_gender" class="block text-sm font-semibold text-gray-900">
                             Gender
                        </label>
                        <div class="mt-2">
                            <select id="card_character_gender"
                                    name="card_character_gender"
                                    value="{{ $card->character->card_character_gender ?? old('card_character_gender') }}"
                                    autocomplete="card_character_gender"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                    <option value="Male" @selected($card->character->card_character_gender ?? 'Male' === 'Male' ? $card->character->card_character_gender ?? '': old('card_character_gender'))>Male</option>
                                    <option value="Female" @selected($card->character->card_character_gender ?? 'Female' === 'Female' ? $card->character->card_character_gender ?? '': old('card_character_gender'))>Female</option>
                                    <option value="Other" @selected($card->character->card_character_gender ?? 'Other' === 'Other' ? $card->character->card_character_gender ?? '': old('card_character_gender'))>Other</option>>Creature</option>
                                    <option value="Other" @selected($card->character->card_character_gender ?? 'Creature' === 'Creature' ? $card->character->card_character_gender ?? '': old('card_character_gender'))>Creature</option>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="card_character_affiliation" class="block text-sm font-semibold text-gray-900">
                           Affiliation
                        </label>
                        <div class="mt-2">
                            <input type="text"
                                    name="card_character_affiliation"
                                    value="{{ $card->character->card_character_affiliation ?? old('card_character_affiliation') }}"
                                    id="card_character_affiliation"
                                    autocomplete="card_character_affiliation"
                                    value="{{ old('card_character_affiliation') }}"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    >
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="card_character_occupation" class="block text-sm font-semibold text-gray-900">
                           Occupation
                        </label>
                        <div class="mt-2">
                            <input type="text"
                                    name="card_character_occupation"
                                    value="{{ $card->character->card_character_occupation ?? old('card_character_occupation') }}"
                                    id="card_character_occupation"
                                    autocomplete="card_character_occupation"
                                    value="{{ old('card_character_occupation') }}"
                                    class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                    >
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="card_character_bio" class="block text-sm font-semibold text-gray-900">
                            Bio
                        </label>
                        <div class="mt-2">
                            <textarea id="card_character_bio"
                                        name="card_character_bio"
                                        rows="5"
                                        class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                                        placeholder="Write a few sentences about this book, manga, or card series.">{{ $card->character->card_character_bio ?? old('card_character_bio') }}</textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            A strong summary helps users understand the tone, setting, and reason to keep reading.
                        </p>
                    </div>


                </div>
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Core Attributes</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Distribute this character's tier points across Physical, Mental, and Spiritual power.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-indigo-50 px-4 py-3 text-center">
                            <p class="text-xs font-semibold uppercase tracking-widest text-indigo-600">
                                Points Left
                            </p>
                            <p id="remainingPoints" class="text-3xl font-black text-indigo-700">0</p>
                        </div>
                    </div>

                    <input type="hidden" id="tierPoints" value="{{ $card_tier_skill_points ?? 20 }}">
                    <input type="hidden" name="card_character_abilities" id="characterStatsJson">

                    <div class="space-y-5">
                        @foreach (['physical' => 'Physical', 'mental' => 'Mental', 'spiritual' => 'Spiritual'] as $key => $label)
                   
                            <div class="skill-row rounded-2xl border border-gray-200 bg-gray-50 p-4" data-skill="{{ $key }}">
                                <div class="flex items-center justify-between">
                                    <label class="font-bold text-gray-800">{{ $label }}</label>
                                    <span class="skill-value text-2xl font-black text-gray-950">{{ $card->character->{'card_character_' . $key} ?? 0 }} </span>
                                </div>

                                <div class="mt-4 flex items-center gap-3">
                                    <button type="button" class="minus-btn rounded-xl border border-gray-300 bg-white px-4 py-2 font-bold text-gray-700 hover:bg-gray-100">
                                        -
                                    </button>

                                    <input type="range" min="0" max="100" name="{{ 'card_character_'. $key }}"  value="{{ $card->character->{'card_character_' . $key} ?? 0 }}"  class="skill-slider w-full">

                                    <button type="button" class="plus-btn rounded-xl bg-indigo-600 px-4 py-2 font-bold text-white hover:bg-indigo-700">
                                        +
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


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
    const totalPoints = parseInt(document.getElementById('tierPoints').value || 0);
    const rows = document.querySelectorAll('.skill-row');
    const remainingPoints = document.getElementById('remainingPoints');
    const statsInput = document.getElementById('characterStatsJson');

    function getUsedPoints() {
        let used = 0;

        rows.forEach(row => {
            used += parseInt(row.querySelector('.skill-slider').value || 0);
        });

        return used;
    }

    function updateDisplay() {
        let stats = {};
        let used = 0;

        rows.forEach(row => {
            const skill = row.dataset.skill;
            const slider = row.querySelector('.skill-slider');
            const value = parseInt(slider.value || 0);

            used += value;
            stats[skill] = value;

            row.querySelector('.skill-value').innerText = value;
        });

        remainingPoints.innerText = totalPoints - used;
        statsInput.value = JSON.stringify(stats);
    }

    rows.forEach(row => {
        const slider = row.querySelector('.skill-slider');
        const plus = row.querySelector('.plus-btn');
        const minus = row.querySelector('.minus-btn');

        plus.addEventListener('click', () => {
            if (getUsedPoints() < totalPoints) {
                slider.value = parseInt(slider.value || 0) + 1;
                updateDisplay();
            }
        });

        minus.addEventListener('click', () => {
            if (parseInt(slider.value || 0) > 0) {
                slider.value = parseInt(slider.value || 0) - 1;
                updateDisplay();
            }
        });

        slider.addEventListener('input', () => {
            updateDisplay();

            const overflow = getUsedPoints() - totalPoints;

            if (overflow > 0) {
                slider.value = parseInt(slider.value || 0) - overflow;
                updateDisplay();
            }
        });
    });

    updateDisplay();
});
</script>