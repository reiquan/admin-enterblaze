<style>
    .perk-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        min-height: 3.25rem;
        padding: 0.75rem;
        border: 1px solid rgb(209 213 219);
        border-radius: 1rem;
        background: white;
        align-items: center;
    }

    .perk-wrapper:focus-within {
        border-color: rgb(79 70 229);
        box-shadow: 0 0 0 3px rgb(199 210 254);
    }

    .perk-wrapper input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 180px;
        font-size: 0.875rem;
        color: rgb(17 24 39);
    }

    .perk-wrapper input:focus {
        box-shadow: none;
        outline: none;
        border: none;
    }

    .perk-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 9999px;
        background: rgb(238 242 255);
        color: rgb(67 56 202);
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .perk-remove {
        cursor: pointer;
        font-weight: 900;
        color: rgb(79 70 229);
    }
</style>

<div class="min-h-screen bg-gray-50 px-6 py-8 lg:px-8">
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

                               
                                <div >
                                    <label for="service_frequency" class="block text-sm font-bold text-gray-900">Service Frequency</label>
                                    <select id="service_frequency" name="service_frequency" autocomplete="service_frequency"   class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600" required>
                                        <option>Monthly</option>
                                        <option>Yearly</option>
                                        <option>One-Time</option>
                                    </select>
                                </div>
                                <div >
                                    <label for="service_category" class="block text-sm font-bold text-gray-900">Service Category</label>
                                    <select id="service_category" name="service_category" autocomplete="service_category"   class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="0">Select a Category</option>
                                        <option value="publishing_services">Publishing</option>
                                        <option value="creator_services">Creator</option>
                                        <option value="influencer_services">Influencer</option>
                                        <option value="fee_service">Fee</option>
                                        <option value="promo_code">Promo Code</option>
                                    </select>
                                </div>
                                <div >
                                    <label for="service_is_on_sale" class="block text-sm font-bold text-gray-900">On Sale</label>
                                    <select id="service_is_on_sale" name="service_is_on_sale" autocomplete="service_is_on_sale"   class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="service_sale_percentage" class="block text-sm font-bold text-gray-900">Service Sale Percentage Off</label>
                                    <input
                                        type="number"
                                        name="service_sale_percentage"
                                        id="service_sale_percentage"
                                        value="{{ old('service_sale_percentage', $service->service_sale_percentage ?? '') }}"
                                        min="0"
                                        class="mt-2 mb-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="25% Off"
                                    >
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="service_sale_ends_at" class="block text-sm font-semibold text-gray-900">
                                        Sale ends on:
                                    </label>
                                    <div class="mt-2">
                                        <input type="date"
                                                name="service_sale_ends_at"
                                                id="service_sale_ends_at"
                                                autocomplete="service_sale_ends_at"
                                                value="{{ old('service_sale_ends_at') }}"
                                                class="block w-full rounded-xl border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                    </div>
                                </div>
       

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
</div>

<script>
    const tokenAmountInput = document.getElementById('service_amount');
    const usdHiddenInput = document.getElementById('service_usd_price');
    const usdPreview = document.getElementById('usd_conversion');
    const conversionRate = 2.50;

    function updateUsdConversion() {
        const amount = parseFloat(tokenAmountInput.value) || 0;
        const usdValue = amount * conversionRate;

        usdHiddenInput.value = usdValue.toFixed(2);
        usdPreview.innerHTML = '$' + usdValue.toFixed(2);
    }

    tokenAmountInput.addEventListener('input', updateUsdConversion);
    updateUsdConversion();
</script>

<script>
    const tagInput = document.getElementById('tag-input');
    const tagContainer = document.getElementById('tag-container');
    const hiddenInput = document.getElementById('event-tags-hidden');

    let tags = [];

    try {
        if (hiddenInput.value) {
            const existingTags = JSON.parse(hiddenInput.value);
            if (Array.isArray(existingTags)) {
                tags = existingTags;
            }
        }
    } catch (e) {
        tags = [];
    }

    tagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();

            let value = this.value.trim();

            if (!value) {
                return;
            }

            if (tags.map(tag => tag.toLowerCase()).includes(value.toLowerCase())) {
                this.value = '';
                return;
            }

            tags.push(value);
            renderTags();
            this.value = '';
        }
    });

    function renderTags() {
        document.querySelectorAll('.perk-tag').forEach(tag => tag.remove());

        tags.forEach((tagText, index) => {
            const tag = document.createElement('div');
            tag.className = 'perk-tag';

            tag.innerHTML = `
                <span>${tagText}</span>
                <span class="perk-remove" onclick="removeTag(${index})">&times;</span>
            `;

            tagContainer.insertBefore(tag, tagInput);
        });

        hiddenInput.value = JSON.stringify(tags);
    }

    function removeTag(index) {
        tags.splice(index, 1);
        renderTags();
    }

    renderTags();
</script>
