<form
    method="POST"
    action="{{ route('contestant.submit', $contest_submission) }}"
    class="space-y-8"
>
    @csrf

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-100 p-6 sm:p-8">
            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                Step 4
            </p>

            <h2 class="mt-3 text-3xl font-black tracking-tight text-gray-950">
                Review Your Submission
            </h2>

            <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-600">
                Please verify everything below before submitting your contest entry.
                Once submitted, your project will be sent to the judges for review.
            </p>
        </div>

        <div class="space-y-8 p-6 sm:p-8">

            {{-- Contest Information --}}
            <div class="rounded-3xl border border-gray-200 p-6">

                <h3 class="text-lg font-black text-gray-900">
                    Contest Information
                </h3>

                <dl class="mt-6 grid gap-6 md:grid-cols-2">

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-gray-500">
                            Title
                        </dt>

                        <dd class="mt-2 text-lg font-bold text-gray-900">
                            {{ $contest_submission->submission_title }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-gray-500">
                            Category
                        </dt>

                        <dd class="mt-2 text-lg font-bold text-gray-900">
                            {{ $contest_submission->submission_category }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-gray-500">
                            Universe
                        </dt>

                        <dd class="mt-2 text-lg font-bold text-gray-900">
                            {{ optional($contest_submission->universe)->universe_name }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-gray-500">
                            External Link
                        </dt>

                        <dd class="mt-2">
                            @if($contest_submission->submission_url)
                                <a
                                    href="{{ $contest_submission->submission_url }}"
                                    target="_blank"
                                    class="font-bold text-indigo-600 hover:underline"
                                >
                                    View Link
                                </a>
                            @else
                                <span class="text-gray-400">
                                    None
                                </span>
                            @endif
                        </dd>
                    </div>

                </dl>

                <div class="mt-8">
                    <dt class="text-xs font-black uppercase tracking-wider text-gray-500">
                        Description
                    </dt>

                    <dd class="mt-3 rounded-2xl bg-gray-50 p-5 text-sm leading-7 text-gray-700">
                        {{ $contest_submission->submission_description }}
                    </dd>
                </div>

            </div>

            {{-- Thumbnail --}}
            <div class="rounded-3xl border border-gray-200 p-6">

                <h3 class="text-lg font-black text-gray-900">
                    Contest Thumbnail
                </h3>

                <div class="mt-6 max-w-lg overflow-hidden rounded-2xl">

                    @if($contest_submission->primaryThumbnail)

                        <img
                            src="{{ Storage::disk('s3-public')->url($contest_submission->primaryThumbnail->file_path) }}"
                            class="w-full object-cover"
                            alt=""
                        >

                    @endif

                </div>

            </div>

            {{-- Pages --}}
            <div class="rounded-3xl border border-gray-200 p-6">

                <div class="flex items-center justify-between">

                    <h3 class="text-lg font-black text-gray-900">
                        Submission Pages
                    </h3>

                    <span class="rounded-full bg-indigo-100 px-4 py-2 text-xs font-black text-indigo-700">
                        {{ $contest_submission->files()->where('file_type', \App\Models\ContestSubmissionFile::TYPE_IMAGE)->count() }}
                        Pages
                    </span>

                </div>

                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

                    @foreach(
                        $contest_submission->files
                            ->where('file_type', \App\Models\ContestSubmissionFile::TYPE_IMAGE)
                            ->sortBy('sort_order')
                        as $page
                    )

                        <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">

                            <div class="relative">

                                <img
                                    src="{{ Storage::disk('s3-public')->url($page->file_path) }}"
                                    class="aspect-[3/4] w-full object-cover"
                                >

                                <div class="absolute left-3 top-3 rounded-full bg-black/80 px-3 py-1 text-xs font-black text-white">
                                    Page {{ $page->sort_order }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- Confirmation --}}
            <div class="rounded-3xl border border-green-200 bg-green-50 p-6">

                <div class="flex gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-600 text-white">

                        ✓

                    </div>

                    <div>

                        <h3 class="text-lg font-black text-green-900">
                            Ready to Submit
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-green-800">
                            By clicking Submit Entry, you confirm this is your final
                            contest submission and understand it will be reviewed by
                            Enterblaze judges.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">

        <a
            href="{{ url()->previous() }}"
            class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-black text-gray-700 transition hover:bg-gray-50"
        >
            Back
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-8 py-4 text-sm font-black uppercase tracking-[0.2em] text-white shadow-lg transition hover:bg-green-700"
        >
            Submit Entry
        </button>

    </div>

</form>