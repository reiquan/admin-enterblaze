<form
    method="POST"
    action="{{ route('contestant.update', $contest_submission) }}"
    enctype="multipart/form-data"
    class="space-y-8"
    id="contest-pages-form"
>
    @csrf
    @method('PATCH')

    <input type="hidden" name="step" value="3">
    <input
        type="hidden"
        name="file_type"
        value="{{ \App\Models\ContestSubmissionFile::TYPE_IMAGE }}"
    >

    @if($errors->any())
        <div class="rounded-3xl border border-red-200 bg-red-50 p-6 shadow-sm">
            <h3 class="text-sm font-black text-red-900">
                Please fix the following:
            </h3>

            <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 p-6 sm:p-8">
            <p class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600">
                Step 3
            </p>

            <h2 class="mt-3 text-2xl font-black tracking-tight text-gray-950">
                Upload Submission Pages
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                Upload your entry pages in the order they should be viewed.
                You may submit between 1 and 5 pages.
            </p>
        </div>

        <div class="p-6 sm:p-8">
            <label
                for="contest_files"
                class="block text-sm font-black text-gray-900"
            >
                Submission Pages
            </label>

            <div
                id="contest-pages-dropzone"
                class="mt-3 rounded-3xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center transition hover:border-indigo-400 hover:bg-indigo-50/40"
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
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"
                    />
                </svg>

                <p class="mt-4 text-sm font-black text-gray-900">
                    Select up to 5 page images
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    JPG, PNG, or WEBP. Maximum 10 MB per page.
                </p>

                <label
                    for="contest_files"
                    class="mt-5 inline-flex cursor-pointer items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700"
                >
                    Choose Pages
                </label>

                <input
                    id="contest_files"
                    name="contest_files[]"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    required
                    class="sr-only"
                >
            </div>

            @error('contest_files')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @error('contest_files.*')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <div class="mt-6 flex items-center justify-between">
                <p class="text-sm font-bold text-gray-700">
                    Selected pages
                </p>

                <p
                    id="contest-page-count"
                    class="rounded-full bg-gray-100 px-3 py-1 text-xs font-black text-gray-600"
                >
                    0 / 5
                </p>
            </div>

            <div
                id="contest-pages-error"
                class="mt-3 hidden rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700"
            ></div>

            <div
                id="contest-pages-preview"
                class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
            ></div>

            <div class="mt-8 rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                <p class="text-xs font-black uppercase tracking-[0.25em] text-indigo-600">
                    Page order
                </p>

                <p class="mt-3 text-sm leading-6 text-indigo-950">
                    Pages will be stored in the same order that you select them.
                    Rename your files before uploading, such as
                    <strong>page-1.jpg</strong>, <strong>page-2.jpg</strong>,
                    and so on.
                </p>
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
            id="contest-pages-submit"
            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-gray-400"
        >
            Save Pages & Continue
            <span class="ml-2">→</span>
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const maximumPages = 5;

        const form = document.getElementById('contest-pages-form');
        const fileInput = document.getElementById('contest_files');
        const previewContainer = document.getElementById('contest-pages-preview');
        const pageCount = document.getElementById('contest-page-count');
        const errorContainer = document.getElementById('contest-pages-error');
        const submitButton = document.getElementById('contest-pages-submit');

        let previewUrls = [];

        const clearPreviewUrls = () => {
            previewUrls.forEach((url) => URL.revokeObjectURL(url));
            previewUrls = [];
        };

        const displayError = (message) => {
            errorContainer.textContent = message;
            errorContainer.classList.remove('hidden');
        };

        const clearError = () => {
            errorContainer.textContent = '';
            errorContainer.classList.add('hidden');
        };

        const resetInput = () => {
            fileInput.value = '';
            clearPreviewUrls();
            previewContainer.innerHTML = '';
            pageCount.textContent = `0 / ${maximumPages}`;
        };

        fileInput?.addEventListener('change', () => {
            clearError();
            clearPreviewUrls();
            previewContainer.innerHTML = '';

            const files = Array.from(fileInput.files ?? []);

            if (files.length > maximumPages) {
                resetInput();

                displayError(
                    `You may upload no more than ${maximumPages} pages.`
                );

                return;
            }

            const invalidFile = files.find(
                (file) => ![
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ].includes(file.type)
            );

            if (invalidFile) {
                resetInput();

                displayError(
                    `${invalidFile.name} is not a supported image type.`
                );

                return;
            }

            pageCount.textContent = `${files.length} / ${maximumPages}`;

            files.forEach((file, index) => {
                const previewUrl = URL.createObjectURL(file);
                previewUrls.push(previewUrl);

                const previewCard = document.createElement('div');

                previewCard.className =
                    'overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm';

                previewCard.innerHTML = `
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                        <img
                            src="${previewUrl}"
                            alt="Page ${index + 1}"
                            class="h-full w-full object-cover"
                        >

                        <div class="absolute left-3 top-3 rounded-full bg-black/75 px-3 py-1 text-xs font-black text-white">
                            Page ${index + 1}
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="truncate text-sm font-black text-gray-900">
                            ${file.name}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            ${(file.size / 1024 / 1024).toFixed(2)} MB
                        </p>
                    </div>
                `;

                previewContainer.appendChild(previewCard);
            });
        });

        form?.addEventListener('submit', (event) => {
            const files = Array.from(fileInput.files ?? []);

            clearError();

            if (files.length < 1) {
                event.preventDefault();

                displayError('Please select at least one submission page.');

                return;
            }

            if (files.length > maximumPages) {
                event.preventDefault();

                displayError(
                    `You may upload no more than ${maximumPages} pages.`
                );

                return;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Uploading Pages...';
        });
    });
</script>