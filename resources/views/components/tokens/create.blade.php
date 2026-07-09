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
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">Blaze Tokens</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950">Create Token Tier</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                            Build purchasable Blaze Token packages for your members. Add the token amount, USD conversion, feature status, and perks included with this tier.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-indigo-100 bg-white p-5 shadow-sm">
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">Current Conversion</p>
                        <p class="mt-2 text-3xl font-black text-indigo-700">$2.50</p>
                        <p class="mt-1 text-xs font-semibold text-gray-500">per Blaze Token</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('tokens.tiers.submit') }}">
                @csrf

                <div class="grid gap-8 p-8 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="border-b border-gray-200 pb-5">
                                <h2 class="text-lg font-black text-gray-950">Tier Information</h2>
                                <p class="mt-1 text-sm text-gray-500">Basic details for this Blaze Token package.</p>
                            </div>

                            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="token_tier_name" class="block text-sm font-bold text-gray-900">Tier Name</label>
                                    <input
                                        type="text"
                                        name="token_tier_name"
                                        id="token_tier_name"
                                        value="{{ old('token_tier_name', $tier->token_tier_name ?? '') }}"
                                        class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="Starter Pack, Creator Bundle, Premium Vault..."
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="tag" class="block text-sm font-bold text-gray-900">Tag</label>
                                    <input
                                        type="text"
                                        name="tag"
                                        id="tag"
                                        value="{{ old('tag', $tier->tag ?? '') }}"
                                        class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="popular, best-value, starter"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="token_tier_amount" class="block text-sm font-bold text-gray-900">Blaze Token Amount</label>
                                    <input
                                        type="number"
                                        name="token_tier_amount"
                                        id="token_tier_amount"
                                        value="{{ old('token_tier_amount', $tier->token_tier_amount ?? '') }}"
                                        min="0"
                                        class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="25"
                                        required
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="token_tier_description" class="block text-sm font-bold text-gray-900">Description</label>
                                    <textarea
                                        id="token_tier_description"
                                        name="token_tier_description"
                                        rows="5"
                                        class="mt-2 block w-full rounded-2xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="Write a short description about what this tier includes."
                                    >{{ old('token_tier_description', $tier->token_tier_description ?? '') }}</textarea>
                                    <p class="mt-2 text-xs font-semibold text-gray-500">This can be displayed publicly on your token purchase page.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <div class="border-b border-gray-200 pb-5">
                                <h2 class="text-lg font-black text-gray-950">Tier Perks</h2>
                                <p class="mt-1 text-sm text-gray-500">Add benefits users receive with this token tier.</p>
                            </div>

                            <div class="mt-6">
                                <label for="tag-input" class="block text-sm font-bold text-gray-900">Perks</label>
                                <div id="tag-container" class="perk-wrapper mt-2">
                                    <input type="text" id="tag-input" placeholder="Type a perk and press Enter">
                                </div>
                                <input type="hidden" name="perks" id="event-tags-hidden" value="{{ old('perks', $tier->perks ?? '') }}">
                                <p class="mt-2 text-xs font-semibold text-gray-500">Example: Early access, bonus cards, member badge, creator discount.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-black text-gray-950">USD Preview</h2>
                            <p class="mt-1 text-sm text-gray-500">Calculated from the Blaze Token amount.</p>

                            <div class="mt-6 rounded-3xl bg-gray-950 p-6 text-white">
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400">Conversion to USD</p>
                                <p id="usd_conversion" class="mt-3 text-4xl font-black">$0.00</p>
                                <p class="mt-2 text-xs font-semibold text-gray-400">Hidden value will submit with the form.</p>
                            </div>

                            <input
                                type="hidden"
                                name="token_tier_usd_price"
                                id="token_tier_usd_price"
                                value="{{ old('token_tier_usd_price', $tier->token_tier_usd_price ?? '') }}"
                            >
                        </div>

                        <fieldset class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                            <legend class="text-lg font-black text-gray-950">Feature Tier</legend>
                            <p class="mt-1 text-sm text-gray-500">Choose whether this tier should be highlighted.</p>

                            <div class="mt-5 space-y-3">
                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:border-indigo-300 hover:bg-indigo-50">
                                    <input
                                        type="radio"
                                        name="featured"
                                        value="0"
                                        class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('featured', $tier->featured ?? 0) == 0 ? 'checked' : '' }}
                                    >
                                    <span>
                                        <span class="block text-sm font-black text-gray-950">Do Not Feature</span>
                                        <span class="mt-1 block text-xs font-semibold text-gray-500">Keep this tier as a regular listing.</span>
                                    </span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:border-indigo-300 hover:bg-indigo-50">
                                    <input
                                        type="radio"
                                        name="featured"
                                        value="1"
                                        class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        {{ old('featured', $tier->featured ?? 0) == 1 ? 'checked' : '' }}
                                    >
                                    <span>
                                        <span class="block text-sm font-black text-gray-950">Feature</span>
                                        <span class="mt-1 block text-xs font-semibold text-gray-500">Highlight this tier as a promoted option.</span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-8 py-6 sm:flex-row sm:items-center sm:justify-end">
                    <a
                        href="{{ route('tokens.tiers.index') }}"
                        class="inline-flex justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-100"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                    >
                        Save Tier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const tokenAmountInput = document.getElementById('token_tier_amount');
    const usdHiddenInput = document.getElementById('token_tier_usd_price');
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
