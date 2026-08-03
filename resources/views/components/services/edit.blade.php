<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<style>
.tag-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    min-height: 45px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    align-items: center;
}

.tag-wrapper input {
    border: none;
    outline: none;
    flex: 1;
    min-width: 150px;
}

.tag {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #0d6efd;
    color: white;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 14px;
}

.tag-remove {
    cursor: pointer;
    font-weight: bold;
}
</style>
<form method="POST" action="{{ route('services.update', $service->id) }}">
    @csrf
    <input type="hidden" name="service_id" value="{{ $service->id }}">
    <div class="mx-auto max-w-6xl space-y-8">

<div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 bg-gradient-to-br from-indigo-50 via-white to-white p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Services</p>
                <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950">Create a Service to charge your clients</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                    Build purchasable Servicepackages for your members. Add the token amount, USD conversion, feature status, and perks included with this service.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('services.submit') }}">
        @csrf

        <div class="grid gap-8 p-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="border-b border-gray-200 pb-5">
                        <h2 class="text-lg font-black text-gray-950">Service Information</h2>
                        <p class="mt-1 text-sm text-gray-500">Basic details for this Service package.</p>
                    </div>

                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="service_name" class="block text-sm font-bold text-gray-900">Service Name</label>
                            <input
                                type="text"
                                name="service_name"
                                id="service_name"
                                value="{{ old('service_name', $service->service_name ?? '') }}"
                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                placeholder="Starter Pack, Creator Bundle, Premium Vault..."
                                required
                            >
                        </div>

                        <div>
                            <label for="tag" class="block text-sm font-bold text-gray-900">Service Tag</label>
                            <input
                                type="text"
                                name="service_tag"
                                id="service_tag"
                                value="{{ old('service_tag', $service->service_tag ?? '') }}"
                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                placeholder="popular, best-value, starter"
                                required
                            >
                        </div>
                        <div>
                            <label for="service_price" class="block text-sm font-bold text-gray-900">Service Price</label>
                            <input
                                type="number"
                                name="service_price"
                                id="service_price"
                                value="{{ old('service_price', $service->service_price ?? '') }}"
                                min="0"
                                class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                placeholder="25"
                                required
                            >
                        </div>

                       
                        <select id="service_frequency"
                                name="service_frequency"
                                x-model="service_frequency"
                                class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600">
                            <option value="">Select Service  Frequency</option>
                            @foreach(['Monthly', 'Yearly', 'One-Time'] as $frequency)
                                <option value="{{ $frequency }}" @selected(old('service_frequency', $service->service_frequency ?? '') === $frequency)>{{ $frequency }}</option>
                            @endforeach
                        </select>


                        <div class="sm:col-span-2">
                            <label for="service_description" class="block text-sm font-bold text-gray-900">Service Description</label>
                            <textarea
                                id="service_description"
                                name="service_description"
                                rows="5"
                                class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                placeholder="Write a short description about what this service includes."
                            >{{ old('service_description', $service->service_description ?? '') }}</textarea>
                            <p class="mt-2 text-xs font-semibold text-gray-500">This can be displayed publicly on your service purchase page.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="border-b border-gray-200 pb-5">
                        <h2 class="text-lg font-black text-gray-950">Service Perks</h2>
                        <p class="mt-1 text-sm text-gray-500">Add benefits users receive with this token service.</p>
                    </div>

                    <div class="mt-6">
                        <label for="tag-input" class="block text-sm font-bold text-gray-900">Perks</label>
                        <div id="tag-container" class="perk-wrapper mt-2">
                            <input type="text" id="tag-input" placeholder="Type a perk and press Enter">
                        </div>
                        <input type="hidden" name="service_perks" id="event-tags-hidden" value="{{ old('service_perks', $service->service_perks ?? '') }}">
                        <p class="mt-2 text-xs font-semibold text-gray-500">Example: Early access, bonus cards, member badge, creator discount.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">

                        <fieldset class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <legend class="text-lg font-black text-gray-950">Feature service</legend>
                            <p class="mt-1 text-sm text-gray-500">Choose whether this service should be highlighted.</p>

                            <div class="mt-5 space-y-3">
                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:border-indigo-300 hover:bg-indigo-50">
                                    <input
                                        type="radio"
                                        name="service_featured"
                                        value="0"
                                        class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('service_featured', $service->service_featured ?? 0) == 0 ? 'checked' : '' }}
                                    >
                                    <span>
                                        <span class="block text-sm font-black text-gray-950">Do Not Feature</span>
                                        <span class="mt-1 block text-xs font-semibold text-gray-500">Keep this service as a regular listing.</span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:border-indigo-300 hover:bg-indigo-50">
                                    <input
                                        type="radio"
                                        name="service_featured"
                                        value="1"
                                        class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('service_featured', $service->service_featured ?? 0) == 1 ? 'checked' : '' }}
                                    >
                                    <span>
                                        <span class="block text-sm font-black text-gray-950">Feature</span>
                                        <span class="mt-1 block text-xs font-semibold text-gray-500">Highlight this service as a promoted option.</span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
                    </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-8 py-6 sm:flex-row sm:items-center sm:justify-end">
            <a
                href="{{ route('services.index') }}"
                class="inline-flex justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-100"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
            >
                Save service
            </button>
        </div>
    </form>
</div>
</div>

  <div class="mt-6 flex items-center justify-end gap-x-6 p-6">
    <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>
</form>

<script>
    let conversion = document.getElementById('service_amount');
    console.log(conversion.value);
    conversion.onchange = function() {   

        let usdConversion = document.getElementById('service_usd_price');
        

        usdConversion.value = conversion.value * 2.50.toFixed(2);

        let truncatedNumber = Math.floor(usdConversion.value * 100) / 100;

        usd = document.getElementById('usd_conversion').innerHTML = '$' + truncatedNumber.toFixed(2);


        console.log(usdConversion.value);

    };
</script>
<script>
const tagInput = document.getElementById('tag-input');
const tagContainer = document.getElementById('tag-container');
const hiddenInput = document.getElementById('event-tags-hidden');

let tags = [];

tagInput.addEventListener('keydown', function(e) {

    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();

        let value = this.value.trim();

        if (!value) {
            return;
        }

        if (tags.includes(value.toLowerCase())) {
            this.value = '';
            return;
        }

        tags.push(value);
        renderTags();

        this.value = '';
    }
});

function renderTags() {

    document.querySelectorAll('.tag').forEach(tag => tag.remove());

    tags.forEach((tagText, index) => {

        const tag = document.createElement('div');
        tag.className = 'tag';

        tag.innerHTML = `
            <span>${tagText}</span>
            <span class="tag-remove" onclick="removeTag(${index})">&times;</span>
        `;

        tagContainer.insertBefore(tag, tagInput);
    });

    hiddenInput.value = JSON.stringify(tags);
}

function removeTag(index) {
    tags.splice(index, 1);
    renderTags();
}
</script>