
        <div
            x-data="{
                isLivestream: {{ old(
                    'event_is_livestream',
                    $event->event_is_livestream ?? false
                ) ? 'true' : 'false' }},

                livestreamType: @js(old(
                    'event_livestream_type',
                    $event->event_livestream_type ?? 'encoder'
                ))
            }"
            class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <div class="flex items-start gap-4">
                <input
                    type="checkbox"
                    id="event_is_livestream"
                    name="event_is_livestream"
                    value="1"
                    x-model="isLivestream"
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >

                <div>
                    <label
                        for="event_is_livestream"
                        class="font-semibold text-gray-900"
                    >
                        This event is a livestream
                    </label>

                    <p class="mt-1 text-sm text-gray-500">
                        Create a corresponding scheduled broadcast through Restream.
                    </p>
                </div>
            </div>

            <div
                x-show="isLivestream"
                x-cloak
                class="mt-6 space-y-6 border-t border-gray-100 pt-6"
            >
                <div>
                    <label
                        for="event_livestream_type"
                        class="block text-sm font-semibold text-gray-900"
                    >
                        Livestream source
                    </label>

                    <select
                        id="event_livestream_type"
                        name="event_livestream_type"
                        x-model="livestreamType"
                        class="mt-2 block w-full rounded-xl border-gray-300"
                    >
                        <option value="encoder">
                            OBS or external encoder
                        </option>

                        <option value="studio">
                            Restream Studio
                        </option>

                        <option value="file">
                            Scheduled pre-recorded video
                        </option>
                    </select>

                    <p class="mt-2 text-sm text-gray-500">
                        Encoder requires OBS to be streaming. A pre-recorded file can
                        begin automatically at the scheduled time.
                    </p>
                </div>

                <div
                    x-show="livestreamType === 'file'"
                    x-cloak
                    class="grid gap-5 sm:grid-cols-2"
                >
                    <div>
                        <label
                            for="event_restream_file_id"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Restream storage file ID
                        </label>

                        <input
                            type="text"
                            id="event_restream_file_id"
                            name="event_restream_file_id"
                            value="{{ old(
                                'event_restream_file_id',
                                $event->event_restream_file_id ?? ''
                            ) }}"
                            placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                            class="mt-2 block w-full rounded-xl border-gray-300"
                        >
                    </div>

                    <div>
                        <label
                            for="event_restream_loops"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Extra loops
                        </label>

                        <select
                            id="event_restream_loops"
                            name="event_restream_loops"
                            class="mt-2 block w-full rounded-xl border-gray-300"
                        >
                            @for($loop = 0; $loop <= 9; $loop++)
                                <option
                                    value="{{ $loop }}"
                                    @selected(
                                        old(
                                            'event_restream_loops',
                                            $event->event_restream_loops ?? 0
                                        ) == $loop
                                    )
                                >
                                    {{ $loop }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                @if(!empty($event?->event_restream_id))
                    <div class="rounded-xl bg-green-50 p-4">
                        <p class="text-sm font-semibold text-green-800">
                            Restream event connected
                        </p>

                        <p class="mt-1 break-all text-xs text-green-700">
                            {{ $event->event_restream_id }}
                        </p>

                        <p class="mt-2 text-sm text-green-700">
                            Status:
                            {{ $event->event_restream_status ?? 'Pending' }}
                        </p>
                    </div>
                @endif

                @if(!empty($event?->event_restream_error))
                    <div class="rounded-xl bg-red-50 p-4 text-sm text-red-700">
                        {{ $event->event_restream_error }}
                    </div>
                @endif
            </div>
        </div>
