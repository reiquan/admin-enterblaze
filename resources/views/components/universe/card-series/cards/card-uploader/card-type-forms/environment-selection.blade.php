<div class="sm:col-span-3">
    <label for="card_location_environment" class="block text-sm font-semibold text-gray-900">
        Environment
    </label>

    @php
        $selectedEnvironment = old(
            'card_location_environment',
            $card->location->card_location_environment ?? ''
        );
    @endphp

    <div class="mt-2">
        <select id="card_location_environment"
                name="card_location_environment"
                autocomplete="card_location_environment"
                class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">

            <optgroup label="Natural Environments">
                <option value="Forest" @selected($selectedEnvironment === 'Forest')>Forest</option>
                <option value="Ancient Forest" @selected($selectedEnvironment === 'Ancient Forest')>Ancient Forest</option>
                <option value="Jungle" @selected($selectedEnvironment === 'Jungle')>Jungle</option>
                <option value="Bamboo Grove" @selected($selectedEnvironment === 'Bamboo Grove')>Bamboo Grove</option>
                <option value="Swamp" @selected($selectedEnvironment === 'Swamp')>Swamp</option>
                <option value="Marshlands" @selected($selectedEnvironment === 'Marshlands')>Marshlands</option>
                <option value="Savannah" @selected($selectedEnvironment === 'Savannah')>Savannah</option>
                <option value="Grasslands" @selected($selectedEnvironment === 'Grasslands')>Grasslands</option>
                <option value="Plains" @selected($selectedEnvironment === 'Plains')>Plains</option>
                <option value="Desert" @selected($selectedEnvironment === 'Desert')>Desert</option>
                <option value="Oasis" @selected($selectedEnvironment === 'Oasis')>Oasis</option>
                <option value="Canyon" @selected($selectedEnvironment === 'Canyon')>Canyon</option>
                <option value="Volcano" @selected($selectedEnvironment === 'Volcano')>Volcano</option>
                <option value="Tundra" @selected($selectedEnvironment === 'Tundra')>Tundra</option>
                <option value="Glacier" @selected($selectedEnvironment === 'Glacier')>Glacier</option>
                <option value="Mountain Range" @selected($selectedEnvironment === 'Mountain Range')>Mountain Range</option>
                <option value="Crystal Caverns" @selected($selectedEnvironment === 'Crystal Caverns')>Crystal Caverns</option>
                <option value="Coastal Cliffs" @selected($selectedEnvironment === 'Coastal Cliffs')>Coastal Cliffs</option>
                <option value="Tropical Island" @selected($selectedEnvironment === 'Tropical Island')>Tropical Island</option>
                <option value="Deep Ocean" @selected($selectedEnvironment === 'Deep Ocean')>Deep Ocean</option>
                <option value="Coral Reef" @selected($selectedEnvironment === 'Coral Reef')>Coral Reef</option>
            </optgroup>

            <optgroup label="Urban Environments">
                <option value="Village" @selected($selectedEnvironment === 'Village')>Village</option>
                <option value="Trade Town" @selected($selectedEnvironment === 'Trade Town')>Trade Town</option>
                <option value="Capital City" @selected($selectedEnvironment === 'Capital City')>Capital City</option>
                <option value="Slums" @selected($selectedEnvironment === 'Slums')>Slums</option>
                <option value="Marketplace" @selected($selectedEnvironment === 'Marketplace')>Marketplace</option>
                <option value="Harbor District" @selected($selectedEnvironment === 'Harbor District')>Harbor District</option>
                <option value="Royal Palace" @selected($selectedEnvironment === 'Royal Palace')>Royal Palace</option>
                <option value="Arena" @selected($selectedEnvironment === 'Arena')>Arena</option>
                <option value="Temple District" @selected($selectedEnvironment === 'Temple District')>Temple District</option>
                <option value="Industrial Zone" @selected($selectedEnvironment === 'Industrial Zone')>Industrial Zone</option>
                <option value="University Campus" @selected($selectedEnvironment === 'University Campus')>University Campus</option>
                <option value="Military Base" @selected($selectedEnvironment === 'Military Base')>Military Base</option>
                <option value="Underground City" @selected($selectedEnvironment === 'Underground City')>Underground City</option>
                <option value="Sky City" @selected($selectedEnvironment === 'Sky City')>Sky City</option>
                <option value="Megacity" @selected($selectedEnvironment === 'Megacity')>Megacity</option>
                <option value="Cyberpunk District" @selected($selectedEnvironment === 'Cyberpunk District')>Cyberpunk District</option>
                <option value="Entertainment Quarter" @selected($selectedEnvironment === 'Entertainment Quarter')>Entertainment Quarter</option>
                <option value="Corporate Tower" @selected($selectedEnvironment === 'Corporate Tower')>Corporate Tower</option>
                <option value="Spaceport" @selected($selectedEnvironment === 'Spaceport')>Spaceport</option>
                <option value="Refugee Settlement" @selected($selectedEnvironment === 'Refugee Settlement')>Refugee Settlement</option>
            </optgroup>

            <optgroup label="Yoruba / Reiden Tapped In">
                <option value="Sacred Osun River" @selected($selectedEnvironment === 'Sacred Osun River')>Sacred Osun River</option>
                <option value="Ifa Temple Grounds" @selected($selectedEnvironment === 'Ifa Temple Grounds')>Ifa Temple Grounds</option>
                <option value="Ase Nexus" @selected($selectedEnvironment === 'Ase Nexus')>Ase Nexus</option>
                <option value="Ancestor Grove" @selected($selectedEnvironment === 'Ancestor Grove')>Ancestor Grove</option>
                <option value="King's Compound" @selected($selectedEnvironment === "King's Compound")>King's Compound</option>
                <option value="Warrior Barracks" @selected($selectedEnvironment === 'Warrior Barracks')>Warrior Barracks</option>
                <option value="Spirit Market" @selected($selectedEnvironment === 'Spirit Market')>Spirit Market</option>
                <option value="Talking Drum Plaza" @selected($selectedEnvironment === 'Talking Drum Plaza')>Talking Drum Plaza</option>
                <option value="Festival Grounds" @selected($selectedEnvironment === 'Festival Grounds')>Festival Grounds</option>
                <option value="Babalawo Sanctuary" @selected($selectedEnvironment === 'Babalawo Sanctuary')>Babalawo Sanctuary</option>
                <option value="Dambe Arena" @selected($selectedEnvironment === 'Dambe Arena')>Dambe Arena</option>
                <option value="Inner Gates" @selected($selectedEnvironment === 'Inner Gates')>Inner Gates</option>
                <option value="Outer Gates" @selected($selectedEnvironment === 'Outer Gates')>Outer Gates</option>
                <option value="Sacred Forest" @selected($selectedEnvironment === 'Sacred Forest')>Sacred Forest</option>
                <option value="Mountain of Trials" @selected($selectedEnvironment === 'Mountain of Trials')>Mountain of Trials</option>
                <option value="Ajogun Wasteland" @selected($selectedEnvironment === 'Ajogun Wasteland')>Ajogun Wasteland</option>
                <option value="Orisa Shrine" @selected($selectedEnvironment === 'Orisa Shrine')>Orisa Shrine</option>
                <option value="River Crossing" @selected($selectedEnvironment === 'River Crossing')>River Crossing</option>
                <option value="Exile Territory" @selected($selectedEnvironment === 'Exile Territory')>Exile Territory</option>
                <option value="Ancestor Realm" @selected($selectedEnvironment === 'Ancestor Realm')>Ancestor Realm</option>
            </optgroup>

            <optgroup label="Sci-Fi Environments">
                <option value="Orbital Station" @selected($selectedEnvironment === 'Orbital Station')>Orbital Station</option>
                <option value="Lunar Colony" @selected($selectedEnvironment === 'Lunar Colony')>Lunar Colony</option>
                <option value="Terraforming Site" @selected($selectedEnvironment === 'Terraforming Site')>Terraforming Site</option>
                <option value="Alien Jungle" @selected($selectedEnvironment === 'Alien Jungle')>Alien Jungle</option>
                <option value="Space Battleship" @selected($selectedEnvironment === 'Space Battleship')>Space Battleship</option>
                <option value="Deep Space" @selected($selectedEnvironment === 'Deep Space')>Deep Space</option>
                <option value="Research Facility" @selected($selectedEnvironment === 'Research Facility')>Research Facility</option>
                <option value="Cryogenic Vault" @selected($selectedEnvironment === 'Cryogenic Vault')>Cryogenic Vault</option>
                <option value="Quantum Laboratory" @selected($selectedEnvironment === 'Quantum Laboratory')>Quantum Laboratory</option>
                <option value="Asteroid Mine" @selected($selectedEnvironment === 'Asteroid Mine')>Asteroid Mine</option>
                <option value="Cyber Grid" @selected($selectedEnvironment === 'Cyber Grid')>Cyber Grid</option>
            </optgroup>

            <optgroup label="Post-Apocalyptic">
                <option value="Ruined City" @selected($selectedEnvironment === 'Ruined City')>Ruined City</option>
                <option value="Wasteland" @selected($selectedEnvironment === 'Wasteland')>Wasteland</option>
                <option value="Nuclear Zone" @selected($selectedEnvironment === 'Nuclear Zone')>Nuclear Zone</option>
                <option value="Survivor Camp" @selected($selectedEnvironment === 'Survivor Camp')>Survivor Camp</option>
                <option value="Underground Bunker" @selected($selectedEnvironment === 'Underground Bunker')>Underground Bunker</option>
            </optgroup>

            <optgroup label="Supernatural / Horror">
                <option value="Haunted Mansion" @selected($selectedEnvironment === 'Haunted Mansion')>Haunted Mansion</option>
                <option value="Cursed Village" @selected($selectedEnvironment === 'Cursed Village')>Cursed Village</option>
                <option value="Blood Moon Field" @selected($selectedEnvironment === 'Blood Moon Field')>Blood Moon Field</option>
                <option value="Cemetery" @selected($selectedEnvironment === 'Cemetery')>Cemetery</option>
                <option value="Catacombs" @selected($selectedEnvironment === 'Catacombs')>Catacombs</option>
                <option value="Shadow Forest" @selected($selectedEnvironment === 'Shadow Forest')>Shadow Forest</option>
                <option value="Nightmare Realm" @selected($selectedEnvironment === 'Nightmare Realm')>Nightmare Realm</option>
                <option value="Vampire Castle" @selected($selectedEnvironment === 'Vampire Castle')>Vampire Castle</option>
            </optgroup>

        </select>
    </div>
</div>