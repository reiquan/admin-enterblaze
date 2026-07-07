<div class="relative overflow-hidden border-b border-gray-200 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 px-6 py-8 text-white sm:px-8">
                    <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -bottom-24 left-16 h-64 w-64 rounded-full bg-purple-300/20 blur-3xl"></div>

                    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-3xl">
                            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-100">
                                {{ $universe->universe_name ?? 'Universe' }}
                            </p>
                            <h1 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                                Build a new card 
                            </h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-100 sm:text-base">
                                Add the core publishing details first. You can continue through the upload and submit steps after this information is saved.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur">
                            <p class="text-xs font-medium uppercase tracking-widest text-indigo-100">Current Step</p>
                            <p class="mt-1 text-2xl font-bold">Step {{ $step ?? 1 }} of 5</p>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 bg-gray-50 px-6 py-5 sm:px-8">
                    <nav aria-label="Progress">
                        <ol role="list" class="grid gap-3 md:grid-cols-3">
                            <li>
                               @if($card_id ?? $card->id)
                                    <form method="get" action="{{ route('cards.create', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}">
                                        @csrf
                                        <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 1) == 1 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                           <button type="submit"> <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 1) == 1 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">1</span></button>
                                            <div>
                                                <p class="text-sm font-semibold">Card Info</p>
                                                <p class="text-xs">Title, creator, audience</p>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 1) == 1 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 1) == 1 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">1</span>
                                        <div>
                                            <p class="text-sm font-semibold">Series Info</p>
                                            <p class="text-xs">Title, creator, audience</p>
                                        </div>
                                    </div>
                               @endif
                            </li>

                            <li>
                                @if($card_id ?? $card->id)
                                    <form method="get" action="{{ route('cards.create', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}">
                                        @csrf
                                        <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <input type="hidden" name="step" value="2">
                                        <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 2) == 2 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                           <button type="submit"> <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 2) == 2 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">2</span></button>
                                           <div>
                                                <p class="text-sm font-semibold">Card Upload</p>
                                                <p class="text-xs">Add artwork and images</p>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 3) == 3 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 2) == 2 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">2</span>
                                        <div>
                                            <p class="text-sm font-semibold">Card Upload</p>
                                            <p class="text-xs">Add artwork and images</p>
                                        </div>
                                    </div>
                               @endif
                            </li>
                            


                            <li>
                                @if($card_id ?? $card->id)
                                    <form method="get" action="{{ route('cards.create', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}">
                                        @csrf
                                        <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <input type="hidden" name="step" value="3">
                                        <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 3) == 3 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                           <button type="submit"> <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 3) == 3 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">3</span></button>
                                           <div>
                                                <p class="text-sm font-semibold">Card Type Info</p>
                                                <p class="text-xs">Review and finish</p>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 3) == 3 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 3) == 3 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">3</span>
                                        <div>
                                            <p class="text-sm font-semibold">Card Type Info</p>
                                            <p class="text-xs">Review and finish</p>
                                        </div>
                                    </div>
                               @endif
                            </li>

                            <li>
                                @if($card_id ?? $card->id)
                                    <form method="get" action="{{ route('cards.create', ['universe_id' => $card->series->universe->id,'card_series_id' => $card->series->id,'card_id' => $card->id]) }}">
                                        @csrf
                                        <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <input type="hidden" name="step" value="4">
                                        <input type="hidden" name="type" value="{{ $card->location->id ?? null}}">
                                        <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 4) == 4 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                           <button type="submit"> <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 4) == 4 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">4</span></button>
                                           <div>
                                                <p class="text-sm font-semibold">Card Character Skills</p>
                                                <p class="text-xs">Review and finish</p>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 4) == 4 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 4) == 4 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">4</span>
                                        <div>
                                            <p class="text-sm font-semibold">Card Character Skills</p>
                                            <p class="text-xs">Review and finish</p>
                                        </div>
                                    </div>
                               @endif
                            </li>

                            <li>
                                @if($card_id ?? $card->id)
                                        <input type="hidden" name="card_series_id" value="{{ $card->series->id }}">
                                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                                        <input type="hidden" name="step" value="5">
                                        <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 5) == 5 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 5) == 5 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">5</span>
                                           <div>
                                                <p class="text-sm font-semibold">Submit</p>
                                                <p class="text-xs">Review and finish</p>
                                            </div>
                                        </div>
                               
                                @else
                                    <div class="flex items-center gap-3 rounded-xl border {{ ($step ?? 5) == 5 ? 'border-indigo-200 bg-indigo-50 text-indigo-700' : 'border-gray-200 bg-white text-gray-500' }} px-4 py-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ ($step ?? 5) == 5 ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500' }} text-sm font-bold">5</span>
                                        <div>
                                            <p class="text-sm font-semibold">Submit</p>
                                            <p class="text-xs">Review and finish</p>
                                        </div>
                                    </div>
                               @endif
                            </li>
                        </ol>
                    </nav>
                </div>