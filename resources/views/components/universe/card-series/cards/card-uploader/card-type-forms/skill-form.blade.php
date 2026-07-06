    <form method="post" action="{{ route('cards.updateCardSkill', ['universe_id' => $universe_id ?? $universe->id, 'card_series_id' => $card_series_id, 'card_id' => $card->id]) }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="step" value="4">
        <input type="hidden" name="card_character_universe_id" value="{{ $universe_id ?? $universe->id }}">
        <input type="hidden" name="card_character_id" value="{{ $card->character->id ?? null }}">
        @if($cardSkills ?? $card_skills)
          
            <input type="hidden" name="card_skill_id_one" value="{{ $cardSkills[0]['id'] ?? null }}">
            <input type="hidden" name="card_skill_id_two" value="{{ $cardSkills[1]['id'] ?? null }}">
      
        @endif

        <input type="hidden" name="card_id" value="{{ $card->id }}">
        @if($cardSkills ?? $card_skills)
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <div class="mb-8 flex items-start justify-between gap-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-indigo-600">
                            Character Skills
                        </p>

                        <h2 class="mt-2 text-2xl font-black text-gray-950">
                            Add Character Skills
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                            Add up to 2 skills before submitting this card. Skills can be attacks, passive abilities, transformations, or special techniques.
                        </p>
                    </div>

                    <div class="hidden rounded-2xl bg-indigo-50 px-4 py-3 text-center sm:block">
                        <p class="text-xs font-bold uppercase tracking-widest text-indigo-600">
                            Max Skills
                        </p>
                        <p class="text-3xl font-black text-indigo-700">
                            2
                        </p>
                    </div>
                </div>

                <div id="skillsWrapper" class="space-y-6">
                    <div class="skill-card rounded-3xl border border-gray-200 bg-gray-50 p-6">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">
                                    Skill Slot
                                </p>
                                <h3 class="skill-title mt-1 text-lg font-black text-gray-900">
                                    Skill 1
                                </h3>
                            </div>

                            <button
                                type="button"
                                class="remove-skill hidden rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50"
                            >
                                Remove
                            </button>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Name
                                </label>
                                <input
                                    type="text"
                                    name="skills[0][card_skill_name]"
                                    value="{{ $cardSkills[0]['card_skill_name'] ?? old('skills[0][card_skill_name]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Dragon Strike"
                                    required>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Type
                                </label>
                                <select
                                    name="skills[0][card_skill_type_id]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">Select Type</option>
                                    @foreach($card_skill_types as $type)
                                    @if(isset($cardSkills[0]['id']) && $type->id == $cardSkills[0]['id'])
                                        <option value="{{$type->id}}" selected>{{$type->card_skill_type_name}}</option>
                                    @else
                                        <option value="{{$type->id}}" >{{$type->card_skill_type_name}}</option>
                                    @endif
                                    
                                @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Element
                                </label>
                                <select
                                    name="skills[0][card_skill_element]"
                                    value="{{ $cardSkills[0]['card_skill_element'] ?? old('skills[0][card_skill_element]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">Select Element</option>
                                    <!-- <option value="Fire">Fire</option>
                                    <option value="Water">Water</option>
                                    <option value="Earth">Earth</option>
                                    <option value="Wind">Wind</option>
                                    <option value="Lightning">Lightning</option>
                                    <option value="Light">Light</option> -->
                                    <option value="None">None</option>
                                        @foreach(['mental' => 'Mental', 'spiritual'=> 'Spiritual', 'physical' => 'Physical'] as $key => $value)
                                        @if(isset($cardSkills[0]['card_skill_element']) && $cardSkills[0]['card_skill_element'] == $key)
                                            <option value="{{$key}}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{$key}}">{{ $value }}</option>
                                        @endif
                                        @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Energy Cost
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    name="skills[0][card_skill_energy_cost]"
                                    value="{{ $cardSkills[0]['card_skill_energy_cost'] ?? old('skills[0][card_skill_energy_cost]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="0"
                                    required>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Cooldown
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    name="skills[0][card_skill_cooldown]"
                                     value="{{ $cardSkills[0]['card_skill_cooldown'] ?? old('skills[0][card_skill_cooldown]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="0"
                                    required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Range
                                </label>
                                <select
                                    name="skills[0][card_skill_range]"
                                    value="{{ $cardSkills[0]['card_skill_range'] ?? old('skills[0][card_skill_range]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Select Range</option>
                                    @foreach(['self' => 'Self', 'touch'=> 'Touch', 'melee' => 'Melee','short' => 'Short', 'medium'=> 'Medium', 'long' => 'Long', 'globe' => 'Globe'] as $key => $value)
                                        @if(isset($cardSkills[0]['card_skill_range']) && $cardSkills[0]['card_skill_range'] == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Condition
                                </label>
                                <select name="skills[0][card_skill_condition]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Condition</option>
                                    @foreach(['dice_roll' => 'Dice Roll', 'coin_toss' => 'Coin Toss'] as $key => $value)
                                        @if(isset($cardSkills[0]['card_skill_condition']) && $cardSkills[0]['card_skill_condition'] == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Description
                                </label>
                                <textarea
                                    rows="5"
                                    name="skills[0][card_skill_description]"
                                    value="{{ $cardSkills[0]['card_skill_description'] ?? old('skills[0][card_skill_description]') }}"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Describe what this skill does..."
                                    required>{{ $cardSkills[0]['card_skill_description'] ?? old('skills[0][card_skill_description]') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <button
                        type="button"
                        id="addSkillBtn"
                        class="rounded-2xl border border-indigo-200 bg-indigo-50 px-6 py-3 text-sm font-black text-indigo-700 hover:bg-indigo-100"
                    >
                    {{ isset($cardSkills[1]) ? 'View Second Skill' : '+ Add Second Skill' }}
                    </button>

                    <button
                        type="submit"
                        class="rounded-2xl bg-indigo-600 px-8 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700"
                    >
                        Save Skills
                    </button>
                </div>
            </div>

                <template id="skillTemplate">
                    
                    <div class="skill-card rounded-3xl border border-gray-200 bg-gray-50 p-6">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">
                                    Skill Slot
                                </p>
                                <h3 class="skill-title mt-1 text-lg font-black text-gray-900">
                                    Skill 2
                                </h3>
                            </div>

                            <button
                                type="button"
                                class="remove-skill rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50"
                            >
                                Remove
                            </button>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Name
                                </label>
                                <input type="text" name="skills[1][card_skill_name]" value="{{ $cardSkills[1]['card_skill_name'] ?? old('skills[1][card_skill_name]') }}" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Spirit Breaker">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Type
                                </label>
                                <select name="skills[1][card_skill_type_id]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Type</option>
                                    @foreach($card_skill_types as $type)
                                    @if(isset($cardSkills[1]['id']) && $type->id == $cardSkills[1]['id'])
                                        <option value="{{$type->id}}" selected>{{$type->card_skill_type_name}}</option>
                                    @else
                                    <option value="{{$type->id}}" >{{$type->card_skill_type_name}}</option>
                                    @endif
                                    
                                @endforeach
                                    
                           
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Element
                                </label>
                                <select name="skills[1][card_skill_element]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Element</option>
                                        <!-- <option value="Fire">Fire</option>
                                        <option value="Water">Water</option>
                                        <option value="Earth">Earth</option>
                                        <option value="Wind">Wind</option>
                                        <option value="Lightning">Lightning</option>
                                        <option value="Light">Light</option> -->
                                        <option value="None">None</option>
                                        @foreach(['mental' => 'Mental', 'spiritual'=> 'Spiritual', 'physical' => 'Physical'] as $key => $value)
                                        @if(isset($cardSkills[1]['card_skill_element']) && $cardSkills[1]['card_skill_element'] == $key)
                                            <option value="{{$key}}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{$key}}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="skills[1][card_character_id]" value="{{ $card->id ?? $card_character_id ?? '' }}">

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Energy Cost
                                </label>
                                <input type="number" min="0" name="skills[1][card_skill_energy_cost]" value="{{ $cardSkills[1]['card_skill_energy_cost'] ?? old('skills[1][card_skill_energy_cost]') }}" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Cooldown
                                </label>
                                <input type="number" min="0" name="skills[1][card_skill_cooldown]" value="{{ $cardSkills[1]['card_skill_cooldown'] ?? old('skills[1][card_skill_cooldown]') }}" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0">
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Range
                                </label>
                                <select name="skills[1][card_skill_range]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Range</option>
                                    <option value="">Select Range</option>
                                    @foreach(['self' => 'Self', 'touch'=> 'Touch', 'melee' => 'Melee','short' => 'Short', 'medium'=> 'Medium', 'long' => 'Long', 'globe' => 'Globe'] as $key => $value)
                                        @if(isset($cardSkills[1]['card_skill_range']) && $cardSkills[1]['card_skill_range'] == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Condition
                                </label>
                                <select name="skills[1][card_skill_condition]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Condition</option>
                                    @foreach(['dice_roll' => 'Dice Roll', 'coin_toss' => 'Coin Toss'] as $key => $value)
                                        @if(isset($cardSkills[1]['card_skill_condition']) && $cardSkills[1]['card_skill_condition'] == $key)
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Description
                                </label>
                                <textarea rows="5" name="skills[1][card_skill_description]" value="{{ $cardSkills[1]['card_skill_description'] ?? old('skills[1][card_skill_description]') }}" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe what this skill does...">{{$cardSkills[1]['card_skill_description'] ?? old('skills[1][card_skill_description]')}}</textarea>
                            </div>
                        </div>
                    </div>
                </template>
        @else
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <div class="mb-8 flex items-start justify-between gap-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-indigo-600">
                            Character Skills
                        </p>

                        <h2 class="mt-2 text-2xl font-black text-gray-950">
                            Add Character Skills
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
                            Add up to 2 skills before submitting this card. Skills can be attacks, passive abilities, transformations, or special techniques.
                        </p>
                    </div>

                    <div class="hidden rounded-2xl bg-indigo-50 px-4 py-3 text-center sm:block">
                        <p class="text-xs font-bold uppercase tracking-widest text-indigo-600">
                            Max Skills
                        </p>
                        <p class="text-3xl font-black text-indigo-700">
                            2
                        </p>
                    </div>
                </div>

                <div id="skillsWrapper" class="space-y-6">
                    <div class="skill-card rounded-3xl border border-gray-200 bg-gray-50 p-6">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">
                                    Skill Slot
                                </p>
                                <h3 class="skill-title mt-1 text-lg font-black text-gray-900">
                                    Skill 1
                                </h3>
                            </div>

                            <button
                                type="button"
                                class="remove-skill hidden rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50"
                            >
                                Remove
                            </button>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Name
                                </label>
                                <input
                                    type="text"
                                    name="skills[0][card_skill_name]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Dragon Strike"
                                    required>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Type
                                </label>
                                <select
                                    name="skills[0][card_skill_type_id]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                    <option value="">Select Type</option>
                                    @foreach($card_skill_types as $type)
                                        <option value="{{$type->id}}">{{$type->card_skill_type_name}}</option>
                                        
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Element
                                </label>
                                <select
                                    name="skills[0][card_skill_element]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select Element</option>
                                    <!-- <option value="Fire">Fire</option>
                                    <option value="Water">Water</option>
                                    <option value="Earth">Earth</option>
                                    <option value="Wind">Wind</option>
                                    <option value="Lightning">Lightning</option>
                                    <option value="Light">Light</option> -->
                                    <option value="None">None</option>
                                    <option value="mental">Mental</option>
                                    <option value="physical">Spiritual</option>
                                    <option value="spiritual">Physical</option>
                                </select>
                            </div>

                            <input
                                type="hidden"
                                name="skills[0][card_character_id]"
                                value="{{ $card->id ?? $card_character_id ?? '' }}"
                            >

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Energy Cost
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    name="skills[0][card_skill_energy_cost]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="0"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Cooldown
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    name="skills[0][card_skill_cooldown]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="0"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Range
                                </label>
                                <select
                                    name="skills[0][card_skill_range]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select Range</option>
                                    <option value="Self">Self</option>
                                    <option value="Touch">Touch</option>
                                    <option value="Melee">Melee</option>
                                    <option value="Short">Short</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Long">Long</option>
                                    <option value="Global">Global</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Condition
                                </label>
                                <select name="skills[0][card_skill_condition]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Condition</option>
                                    <option value="">None</option>
                                    <option value="dice_roll">Dice Roll</option>
                                    <option value="coin_toss">Coin Toss</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-bold text-gray-700">
                                    Skill Description
                                </label>
                                <textarea
                                    rows="5"
                                    name="skills[0][card_skill_description]"
                                    class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Describe what this skill does..."
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <button
                        type="button"
                        id="addSkillBtn"
                        class="rounded-2xl border border-indigo-200 bg-indigo-50 px-6 py-3 text-sm font-black text-indigo-700 hover:bg-indigo-100"
                    >
                        {{ isset($cardSkills[1]) ? 'View Second Skill' : '+ Add Second Skill' }}
                    </button>

                    <button
                        type="submit"
                        class="rounded-2xl bg-indigo-600 px-8 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700"
                    >
                        Save Skills
                    </button>
                </div>
            </div>

            <template id="skillTemplate">
                <div class="skill-card rounded-3xl border border-gray-200 bg-gray-50 p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">
                                Skill Slot
                            </p>
                            <h3 class="skill-title mt-1 text-lg font-black text-gray-900">
                                Skill 2
                            </h3>
                        </div>

                        <button
                            type="button"
                            class="remove-skill rounded-xl border border-red-200 bg-white px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50"
                        >
                            Remove
                        </button>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Skill Name
                            </label>
                            <input type="text" name="skills[1][card_skill_name]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Spirit Breaker">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Skill Type
                            </label>
                            <select name="skills[1][card_skill_type_id]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Type</option>
                                    @foreach($card_skill_types as $type)
                                        <option value="{{$type->id}}">{{$type->card_skill_type_name}}</option>
                                        
                                    @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Element
                            </label>
                            <select name="skills[1][card_skill_element]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Element</option>
                                    <!-- <option value="Fire">Fire</option>
                                    <option value="Water">Water</option>
                                    <option value="Earth">Earth</option>
                                    <option value="Wind">Wind</option>
                                    <option value="Lightning">Lightning</option>
                                    <option value="Light">Light</option> -->
                                    <option value="None">None</option>
                                    <option value="mental">Mental</option>
                                    <option value="physical">Spiritual</option>
                                    <option value="spiritual">Physical</option>
                            </select>
                        </div>

                        <input type="hidden" name="skills[1][card_character_id]" value="{{ $card->id ?? $card_character_id ?? '' }}">

                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Energy Cost
                            </label>
                            <input type="number" min="0" name="skills[1][card_skill_energy_cost]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Cooldown
                            </label>
                            <input type="number" min="0" name="skills[1][card_skill_cooldown]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Range
                            </label>
                            <select name="skills[1][card_skill_range]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Range</option>
                                <option value="Self">Self</option>
                                <option value="Touch">Touch</option>
                                <option value="Melee">Melee</option>
                                <option value="Short">Short</option>
                                <option value="Medium">Medium</option>
                                <option value="Long">Long</option>
                                <option value="Global">Global</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Condition
                            </label>
                            <select name="skills[1][card_skill_condition]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Condition</option>
                                <option value="">None</option>
                                <option value="dice_roll">Dice Roll</option>
                                <option value="coin_toss">Coin Toss</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Skill Description
                            </label>
                            <textarea rows="5" name="skills[1][card_skill_description]" class="w-full rounded-2xl border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe what this skill does..."></textarea>
                        </div>
                    </div>
                </div>
            </template>
        @endif
    </form>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maxSkills = 2;
            const wrapper = document.getElementById('skillsWrapper');
            const addBtn = document.getElementById('addSkillBtn');
            const template = document.getElementById('skillTemplate');

            function refreshSkillUI() {
                const cards = wrapper.querySelectorAll('.skill-card');

                cards.forEach((card, index) => {
                    card.querySelector('.skill-title').textContent = `Skill ${index + 1}`;

                    const removeBtn = card.querySelector('.remove-skill');
                    if (removeBtn) {
                        removeBtn.classList.toggle('hidden', cards.length === 1);
                    }
                });

                addBtn.disabled = cards.length >= maxSkills;
                addBtn.classList.toggle('opacity-50', cards.length >= maxSkills);
                addBtn.classList.toggle('cursor-not-allowed', cards.length >= maxSkills);
                addBtn.textContent = cards.length >= maxSkills ? 'Max 2 Skills Added' : '+ Add Second Skill';
            }

            addBtn.addEventListener('click', () => {
                const currentCount = wrapper.querySelectorAll('.skill-card').length;

                if (currentCount >= maxSkills) {
                    return;
                }

                const clone = template.content.cloneNode(true);
                wrapper.appendChild(clone);
                refreshSkillUI();
            });

            wrapper.addEventListener('click', event => {
                const removeBtn = event.target.closest('.remove-skill');

                if (!removeBtn) {
                    return;
                }

                removeBtn.closest('.skill-card').remove();
                refreshSkillUI();
            });

            refreshSkillUI();
        });
        </script>