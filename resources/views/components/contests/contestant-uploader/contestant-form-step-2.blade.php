<form
    method="POST"
    action="{{ route('contestant.update', $contest_submission) }}"
    enctype="multipart/form-data"
    class="space-y-8"
>
    @csrf
    @method('PATCH')

    <input type="hidden" name="step" value="2">
    <input
        type="hidden"
        name="file_type"
        value="{{ \App\Models\ContestSubmissionFile::TYPE_THUMBNAIL }}"
    >

    @if($errors->any())
        <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
            <div class="flex gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-red-100 font-black text-red-700">
                    !
                </div>

                <div>
                    <h3 class="text-sm font-black text-red-900">
                        Please fix the following before continuing:
                    </h3>

                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 p-6 sm:p-8">
            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                Step 2
            </p>

            <h2 class="mt-3 text-2xl font-black tracking-tight text-gray-950">
                Contest Thumbnail
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                Upload the main promotional image for your contest entry. This uses
                the same file system that will handle your submission assets in Step 3.
            </p>
        </div>

        <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-2">
            <div>
                <label
                    for="contest_file"
                    class="block text-sm font-black text-gray-900"
                >
                    Thumbnail Image
                </label>

                <input
                    id="contest_file"
                    name="contest_file"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    required
                    class="mt-3 block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm
                           file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-600
                           file:px-5 file:py-2 file:text-sm file:font-black file:text-white
                           hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-indigo-500"
                >

                @error('contest_file')
                    <p class="mt-2 text-sm font-semibold text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <div class="mt-6 rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                    <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                        Recommended
                    </p>

                    <ul class="mt-4 space-y-2 text-sm leading-6 text-indigo-950">
                        <li>JPG, PNG, or WEBP</li>
                        <li>Maximum file size: 10 MB</li>
                        <li>Use a 16:9 landscape image</li>
                        <li>Use clear artwork with readable text</li>
                    </ul>
                </div>
            </div>

            <div>
                <p class="block text-sm font-black text-gray-900">
                    Thumbnail Preview
                </p>

                <div
                    id="contest-file-preview-container"
                    class="mt-3 flex aspect-video items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-gray-300 bg-gray-100"
                >
                    @if($contest_submission->primaryThumbnail)
                        <img
                            id="contest-file-preview"
                            src="{{ Storage::disk('s3-public')->url($contest_submission->primaryThumbnail->file_path) }}"
                            alt="{{ $contest_submission->submission_title }}"
                            class="h-full w-full object-cover"
                        >

                        <div
                            id="contest-file-placeholder"
                            class="hidden text-center"
                        >
                            <p class="text-sm font-bold text-gray-500">
                                Select an image to preview it.
                            </p>
                        </div>
                    @else
                        <img
                            id="contest-file-preview"
                            src=""
                            alt=""
                            class="hidden h-full w-full object-cover"
                        >

                        <div
                            id="contest-file-placeholder"
                            class="px-6 text-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="mx-auto h-14 w-14 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Z"
                                />
                            </svg>

                            <p class="mt-3 text-sm font-bold text-gray-500">
                                Select an image to preview it.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <a
            href="{{ url()->previous() }}"
            class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-black text-gray-700 shadow-sm transition hover:bg-gray-50"
        >
            Back
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            Save & Continue
            <span class="ml-2">→</span>
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('contest_file');
        const preview = document.getElementById('contest-file-preview');
        const placeholder = document.getElementById('contest-file-placeholder');

        fileInput?.addEventListener('change', function () {
            const file = this.files?.[0];

            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const previewUrl = URL.createObjectURL(file);

            preview.src = previewUrl;
            preview.alt = file.name;
            preview.classList.remove('hidden');
            placeholder?.classList.add('hidden');

            preview.onload = () => {
                URL.revokeObjectURL(previewUrl);
            };
        });
    });
</script>