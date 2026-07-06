<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 mb-12 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">
                    Card Builder
                </p>
                <h2 class="mt-1 text-xl font-semibold leading-tight text-gray-900">
                    @if($card->id)
                        {{ __('Edit Your Card') }}
                    @else
                        {{ __('Create Your Card') }}
                    @endif
                </h2>
            </div>

            <a href="{{ route('card-series.index', $universe->id ?? $universe_id) }}"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                Back to Series
            </a>
        </div>
        @include('components.universe.card-series.cards.progress')
    </x-slot>
    <div class="bg-gray-50/70 px-4 py-6 sm:px-6 lg:px-8">
        <form
            method="POST"
            action="{{ $action ?? '' }}"
            class="mx-auto max-w-6xl"
        >
            @csrf
            <input type="hidden" name="step" value="{{ $step ?? 3 }}">

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-5.75a.75.75 0 001.5 0v-5a.75.75 0 00-1.5 0v5zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold">Please fix the following:</h3>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @php
         
                $reviewSkills = $card_skills ?? $card->skills;

                $cardImage = Storage::disk('s3-public')->url($card->card_image_one ?? $card->card_image_two) ?? null;
            @endphp

            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-white px-6 py-6 sm:px-8">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-black uppercase tracking-[0.2em] text-emerald-600">
                                    Step {{ $step ?? 3 }} · Submit Review
                                </p>
                                <h1 class="mt-1 text-2xl font-black tracking-tight text-gray-950 sm:text-3xl">
                                    Verify Card Skills
                                </h1>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                                    Review the selected card and confirm the skill setup before finishing. Use one final submit button so this step never accidentally sends a GET request.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-600">
                            {{ $reviewSkills->count() }}/2 Skills Ready
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5">
                    <aside class="border-b border-gray-200 px-6 py-8 sm:px-8 lg:col-span-2 lg:border-b-0 lg:border-r">
                        <div class="sticky top-6 space-y-6">
                            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                                <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-slate-900 p-4">
                                    <div class="overflow-hidden rounded-2xl border border-white/20 bg-white/10 shadow-xl">
                                        @if (!empty($cardImage))
                                            <img
                                                src="{{ $cardImage }}"
                                                alt="{{ $card->card_name ?? 'Card preview' }}"
                                                class="aspect-[2.5/3.5] w-full object-cover"
                                            >
                                        @else
                                            <div class="flex aspect-[2.5/3.5] w-full flex-col items-center justify-center p-8 text-center text-white">
                                                <svg class="h-14 w-14 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3h10.5a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25V5.25Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25h6M9 12h6M9 15.75h3" />
                                                </svg>
                                                <p class="mt-4 text-sm font-bold">No card image yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-5">
                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                                        Card
                                    </p>
                                    <h2 class="mt-2 text-xl font-black text-gray-950">
                                        {{ $card->card_name ?? 'Untitled Card' }}
                                    </h2>
                                    <p class="mt-2 text-sm leading-6 text-gray-500">
                                        {{ $card->card_bio ?? 'Review this card before attaching final skills.' }}
                                    </p>

                                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                                        <div class="rounded-2xl bg-gray-50 p-3">
                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Type</p>
                                            <p class="mt-1 font-black text-gray-900">{{ $card->type->card_type_name ?? $card->type->card_type_name ?? 'Not set' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-gray-50 p-3">
                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Tier</p>
                                            <p class="mt-1 font-black text-gray-900">{{ $card->tier->card_tier_name ?? $card->tier->card_tier_name ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-5">
                                <div class="flex gap-3">
                                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-black text-emerald-900">Before finishing</h3>
                                        <p class="mt-1 text-sm leading-6 text-emerald-800">
                                            Confirm names, skill types, energy costs, cooldowns, ranges, and descriptions are correct.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <section class="px-6 py-8 sm:px-8 lg:col-span-3">
                        <div class="space-y-6">
                            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm">
                                <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-black text-gray-950">Skill Summary</h3>
                                            <p class="text-sm text-gray-500">These are the skills that will be attached to the card.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-5">
                                    @if ($reviewSkills->isNotEmpty())
                                        <div class="space-y-5">
                                            @foreach ($reviewSkills as $index => $skill)
                                                @php
                                                    $skillName = $skill['card_skill_name'] ?? $skill->card_skill_name ?? 'Untitled Skill';
                                                    $skillType = $skill['card_skill_type'] ?? $skill->card_skill_name ?? 'Not set';
                                                    $skillElement = $skill['card_skill_element'] ?? $skill->card_skill_element ?? 'None';
                                                    $skillCondition = $skill['card_skill_condition'] ?? $skill->card_skill_condition ?? 'Not set';
                                                    $energyCost = $skill['card_skill_energy_cost'] ?? $skill->card_skill_energy_cost ?? 0;
                                                    $cooldown = $skill['card_skill_cooldown'] ?? $skill->card_skill_cooldown ?? 0;
                                                    $range = $skill['card_skill_range'] ?? $skill->card_skill_range ?? 'Not set';
                                                    $description = $skill['card_skill_description'] ?? $skill->card_skill_description ?? 'No description added.';
                                                @endphp

                                                <article class="overflow-hidden rounded-3xl border border-gray-200 bg-gray-50">
                                                    <div class="flex flex-col gap-4 border-b border-gray-200 bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                                                        <div>
                                                            <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                                                                Skill {{ $index + 1 }}
                                                            </p>
                                                            <h4 class="mt-1 text-xl font-black text-gray-950">
                                                                {{ $skillName }}
                                                            </h4>
                                                        </div>

                                                        <div class="flex flex-wrap gap-2">
                                                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                                                {{ $skillType }}
                                                            </span>
                                                            <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-700 ring-1 ring-inset ring-purple-600/20">
                                                                {{ $skillElement }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="grid gap-4 p-5 sm:grid-cols-2 xl:grid-cols-4">
                                                        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Condition</p>
                                                            <p class="mt-1 text-sm font-black text-gray-900">{{ $skillCondition }}</p>
                                                        </div>

                                                        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Energy Cost</p>
                                                            <p class="mt-1 text-sm font-black text-gray-900">{{ $energyCost }}</p>
                                                        </div>

                                                        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Cooldown</p>
                                                            <p class="mt-1 text-sm font-black text-gray-900">{{ $cooldown }}</p>
                                                        </div>

                                                        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Range</p>
                                                            <p class="mt-1 text-sm font-black text-gray-900">{{ $range }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="px-5 pb-5">
                                                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                                                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Description</p>
                                                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ $description }}</p>
                                                        </div>
                                                    </div>

                                                    @foreach ($card_skills ?? $card->skills as $skill)
                                                        <input type="hidden" name="card_skill_name" value="{{$skill->card_skill_name }}">
                                                    @endforeach
                                                </article>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex min-h-64 items-center justify-center rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center">
                                            <div>
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                </svg>
                                                <h3 class="mt-4 text-lg font-black text-gray-900">No skills found</h3>
                                                <p class="mt-2 text-sm text-gray-500">Go back and add at least one skill before finishing.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('cards.index',['universe_id' => $universe_id ?? $universe->id, 'card_series_id' => $card_series_id]).'?card_series_id='.$card_series_id }}"
                                    class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700">
                                    Submit & Finish Skills
                            </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
