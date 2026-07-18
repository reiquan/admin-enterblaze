<div class="min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <form method="POST" action="" class="mx-auto max-w-7xl">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">

        <div class="mb-8 overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 bg-gradient-to-r from-indigo-50 via-white to-white px-6 py-8 sm:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                            Event Setup
                        </p>

                        <h1 class="mt-3 text-3xl font-black tracking-tight text-gray-950 sm:text-4xl">
                            Upload Event Promo Image
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                            Add the main promotional image for this event. This artwork will be used across your event pages, cards, and marketing areas.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-indigo-100 bg-white px-5 py-4 text-center shadow-sm">
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400">
                            Step
                        </p>
                        <p class="mt-1 text-3xl font-black text-indigo-600">
                            {{ $step ?? 2 }}
                        </p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mx-6 mt-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700 sm:mx-8">
                    <p class="mb-3 font-black">Please fix the following:</p>
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <div class="sticky top-6 rounded-3xl border border-gray-200 bg-gray-50 p-6">
                        <div class="mb-6 flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-xl font-black text-gray-950">
                                    Promo Artwork
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Upload a clean image that sells the event fast.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm leading-6 text-gray-600">
                            <div class="rounded-2xl border border-gray-200 bg-white p-4">
                                <p class="font-bold text-gray-900">Recommended format</p>
                                <p class="mt-1">Use a wide event banner or poster-style image with readable text.</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white p-4">
                                <p class="font-bold text-gray-900">Suggested size</p>
                                <p class="mt-1">1920 × 1080 for banners, or 1080 × 1350 for poster-style promos.</p>
                            </div>

                            <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-4 text-indigo-700">
                                <p class="font-black">Tip</p>
                                <p class="mt-1">Keep important text centered so it does not get cropped on mobile cards.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">
                                    Upload
                                </p>
                                <h3 class="mt-1 text-lg font-black text-gray-950">
                                    Event Promo Image
                                </h3>
                            </div>

                            <span class="inline-flex w-fit rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-xs font-bold text-gray-600">
                                Image required before publishing
                            </span>
                        </div>

                        <div class="rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-5">
                            @if(Route::is('events.edit'))
                                @livewire('event-image-upload', [
                                    'event_id' => isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : $event->id,
                                    'logo' => $event->event_promo_image ?? '',
                                    'type' => 'edit'
                                ])
                            @else
                                @livewire('event-image-upload', [
                                    'event_id' => isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : $event,
                                    'logo' => $event->event_promo_image ?? '',
                                    'type' => ''
                                ])
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">
                                    Preview
                                </p>
                                <h3 class="mt-1 text-lg font-black text-gray-950">
                                    Current Event Image
                                </h3>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-gray-100">
                            @if(isset($event->event_promo_image) && $event->event_promo_image)
                                <img
                                    src="{{ Storage::disk('s3-public')->url($event->event_promo_image) }}"
                                    alt="Event promo image"
                                    class="aspect-video h-full w-full object-cover object-center"
                                >
                            @else
                                <div class="flex aspect-video items-center justify-center bg-gray-100 p-8 text-center">
                                    <div>
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white text-gray-400 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 text-sm font-bold text-gray-700">
                                            No promo image uploaded yet
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            Your event preview will appear here after upload.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4 border-t border-gray-200 bg-gray-50 px-6 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <a
                    href="{{ url()->previous() }}"
                    class="inline-flex justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-black text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Back
                </a>

                <button
                    type="submit"
                    class="inline-flex justify-center rounded-2xl bg-indigo-600 px-8 py-3 text-sm font-black text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Continue
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('button').forEach((button) => {
            if (!button.hasAttribute('type')) {
                button.setAttribute('type', 'button');
            }
        });
    });
</script>
