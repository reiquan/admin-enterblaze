<aside class="lg:col-span-4">
    <div class="sticky top-6 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-slate-900 p-4">
            <div class="overflow-hidden rounded-2xl border border-white/20 bg-white/10 shadow-xl">
                @if (!empty($card->card_image_one))
                    <img
                        src="{{ Storage::disk('s3-public')->url($card->card_image_one) }}"
                        alt="{{ $card->card_name ?? 'Card preview' }}"
                        class="aspect-[2.5/3.5] w-full object-cover"
                    >
                @else
                    <div class="flex aspect-[2.5/3.5] w-full flex-col items-center justify-center bg-white/10 p-8 text-center text-white">
                        <svg class="h-14 w-14 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3h10.5a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25V5.25Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25h6M9 12h6M9 15.75h3" />
                        </svg>

                        <p class="mt-4 text-sm font-semibold">
                            Card preview
                        </p>

                        <p class="mt-1 text-xs text-indigo-100">
                            Upload artwork to preview this card.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">
                        Card Preview
                    </p>

                    <h3 class="mt-2 text-xl font-black text-gray-950">
                        {{ $card->card_name ?? 'Untitled Card' }}
                    </h3>
                </div>

                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">
                    {{ $card->card_rarity ?? 'Draft' }}
                </span>
            </div>

            <dl class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between gap-4 rounded-xl bg-gray-50 px-4 py-3">
                    <dt class="font-medium text-gray-500">Type</dt>
                    <dd class="font-semibold text-gray-900">
                        {{ $card->type->card_type_name ?? 'Not set' }}
                    </dd>
                </div>

                <div class="flex justify-between gap-4 rounded-xl bg-gray-50 px-4 py-3">
                    <dt class="font-medium text-gray-500">Tier</dt>
                    <dd class="font-semibold text-gray-900">
                        {{ $card->tier->card_tier_name ?? 'Not set' }}
                    </dd>
                </div>

                <div class="flex justify-between gap-4 rounded-xl bg-gray-50 px-4 py-3">
                    <dt class="font-medium text-gray-500">Status</dt>
                    <dd class="font-semibold text-gray-900">
                        {{ !empty($card->card_is_active) ? 'Published' : 'Draft' }}
                    </dd>
                </div>
            </dl>

            @if (!empty($card->card_bio))
                <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">
                        Bio
                    </p>

                    <p class="mt-2 line-clamp-5 text-sm leading-6 text-gray-600">
                        {{ $card->card_bio }}
                    </p>
                </div>
            @endif

            <div class="mt-6 rounded-2xl bg-indigo-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-indigo-700">
                    Tip
                </p>

                <p class="mt-2 text-sm leading-6 text-indigo-900">
                    Use bold card art, a clear name, and a short bio that instantly explains why this card matters.
                </p>
            </div>
        </div>
    </div>
</aside>