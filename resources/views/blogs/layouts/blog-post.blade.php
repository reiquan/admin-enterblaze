{{-- ================================================================
    ENTERBLAZE BLOG EDITOR
    resources/views/blogs/layouts/blog-post.blade.php
================================================================ --}}

<div class="w-full">

    <form
        method="POST"
        id="postForm"
        action="{{ route('blogs.store') }}"
        enctype="multipart/form-data"
        class="space-y-8"
    >
        @csrf


        {{-- ========================================================
            EXISTING POST
        ========================================================= --}}

        @if(isset($post->id))
            <input
                type="hidden"
                name="post_id"
                value="{{ $post->id }}"
            >
        @endif



        {{-- ========================================================
            AUTHOR
        ========================================================= --}}

        <div class="flex items-center gap-4 border-b border-gray-100 pb-6">

            <div class="flex-shrink-0">

                <img
                    class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                    src="{{
                        auth()->user()->photo_url
                            ? config('filesystems.disks.s3-public.url') . auth()->user()->photo_url
                            : 'https://images.unsplash.com/photo-1550525811-e5869dd03032?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80'
                    }}"
                    alt="{{ auth()->user()->name ?? 'Author' }}"
                >

            </div>

            <div>

                <p class="font-bold text-gray-900">
                    {{ auth()->user()->name ?? 'Enterblaze Author' }}
                </p>

                <p class="mt-0.5 text-xs text-gray-500">
                    Enterblaze Publishing System
                </p>

            </div>

        </div>



        {{-- ========================================================
            TITLE
        ========================================================= --}}

        <div>

            <div class="mb-2 flex items-center justify-between">

                <label
                    for="title"
                    class="text-sm font-bold text-gray-900"
                >
                    Blog Title
                </label>

                <span class="text-xs text-red-500">
                    Required
                </span>

            </div>

            <input
                id="title"
                name="title"
                type="text"
                value="{{ old('title', $post->title ?? '') }}"
                required
                maxlength="255"
                autocomplete="off"
                placeholder="Give this story a headline worth clicking..."
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-lg font-semibold text-gray-900 shadow-sm placeholder:font-normal placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500"
            >

            @error('title')
                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>



        {{-- ========================================================
            ARTICLE BODY
        ========================================================= --}}

        <div>

            <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <label class="text-sm font-bold text-gray-900">
                        Article Body
                    </label>

                    <p class="mt-1 text-xs text-gray-500">
                        Write and format your article like a document.
                    </p>

                </div>

                <div
                    id="editor-status"
                    class="text-xs font-medium text-gray-400"
                >
                    Ready
                </div>

            </div>


            <div
                class="overflow-hidden rounded-2xl border border-gray-300 bg-white shadow-sm"
            >

                {{-- =================================================
                    TOOLBAR
                ================================================== --}}

                <div
                    id="editor-toolbar"
                    class="sticky top-0 z-20 flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50 p-2"
                >

                    <button
                        type="button"
                        data-editor-action="paragraph"
                        title="Paragraph"
                        class="editor-button"
                    >
                        P
                    </button>

                    <button
                        type="button"
                        data-editor-action="h1"
                        title="Heading 1"
                        class="editor-button"
                    >
                        H1
                    </button>

                    <button
                        type="button"
                        data-editor-action="h2"
                        title="Heading 2"
                        class="editor-button"
                    >
                        H2
                    </button>

                    <button
                        type="button"
                        data-editor-action="h3"
                        title="Heading 3"
                        class="editor-button"
                    >
                        H3
                    </button>


                    <div class="mx-1 h-6 w-px bg-gray-300"></div>


                    <button
                        type="button"
                        data-editor-action="bold"
                        title="Bold"
                        class="editor-button font-black"
                    >
                        B
                    </button>

                    <button
                        type="button"
                        data-editor-action="italic"
                        title="Italic"
                        class="editor-button italic"
                    >
                        I
                    </button>

                    <button
                        type="button"
                        data-editor-action="underline"
                        title="Underline"
                        class="editor-button underline"
                    >
                        U
                    </button>

                    <button
                        type="button"
                        data-editor-action="strike"
                        title="Strike Through"
                        class="editor-button line-through"
                    >
                        S
                    </button>


                    <div class="mx-1 h-6 w-px bg-gray-300"></div>


                    <button
                        type="button"
                        data-editor-action="bulletList"
                        title="Bullet List"
                        class="editor-button"
                    >
                        •
                    </button>

                    <button
                        type="button"
                        data-editor-action="orderedList"
                        title="Numbered List"
                        class="editor-button"
                    >
                        1.
                    </button>

                    <button
                        type="button"
                        data-editor-action="blockquote"
                        title="Quote"
                        class="editor-button text-lg"
                    >
                        “
                    </button>


                    <div class="mx-1 h-6 w-px bg-gray-300"></div>


                    <button
                        type="button"
                        data-editor-action="alignLeft"
                        title="Align Left"
                        class="editor-button"
                    >
                        ≡
                    </button>

                    <button
                        type="button"
                        data-editor-action="alignCenter"
                        title="Align Center"
                        class="editor-button"
                    >
                        ≡
                    </button>

                    <button
                        type="button"
                        data-editor-action="alignRight"
                        title="Align Right"
                        class="editor-button"
                    >
                        ≡
                    </button>


                    <div class="mx-1 h-6 w-px bg-gray-300"></div>


                    <button
                        type="button"
                        id="editor-link"
                        title="Add Link"
                        class="editor-button"
                    >
                        🔗
                    </button>

                    <button
                        type="button"
                        data-editor-action="horizontalRule"
                        title="Horizontal Rule"
                        class="editor-button"
                    >
                        ―
                    </button>


                    <div class="mx-1 h-6 w-px bg-gray-300"></div>


                    <button
                        type="button"
                        data-editor-action="undo"
                        title="Undo"
                        class="editor-button"
                    >
                        ↶
                    </button>

                    <button
                        type="button"
                        data-editor-action="redo"
                        title="Redo"
                        class="editor-button"
                    >
                        ↷
                    </button>

                </div>



                {{-- =================================================
                    TIPTAP EDITOR
                ================================================== --}}

                <div
                    id="tiptap-editor"
                    class="min-h-[600px]"
                ></div>


                {{-- Laravel receives the editor HTML here --}}

                <textarea
                    id="content"
                    name="content"
                    class="hidden"
                >{{ old('content', $post->content ?? '') }}</textarea>

            </div>


            @error('content')
                <p class="mt-2 text-sm font-medium text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>



        {{-- ========================================================
            OPTIONAL POST SETTINGS
        ========================================================= --}}

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <button
                type="button"
                id="toggle-blog-settings"
                class="flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-gray-50"
            >

                <div>

                    <h3 class="text-sm font-bold text-gray-900">
                        Post Settings
                    </h3>

                    <p class="mt-1 text-xs text-gray-500">
                        Optional publishing, organization and SEO settings.
                    </p>

                </div>

                <svg
                    id="blog-settings-arrow"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-5 w-5 text-gray-400 transition-transform"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m19.5 8.25-7.5 7.5-7.5-7.5"
                    />
                </svg>

            </button>


            <div
                id="blog-settings"
                class="hidden border-t border-gray-100 p-5 sm:p-6"
            >

                <div class="grid gap-6 md:grid-cols-2">


                    {{-- SUMMARY --}}

                    <div class="md:col-span-2">

                        <label
                            for="summary"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Summary
                        </label>

                        <p class="mt-1 text-xs text-gray-500">
                            Short preview text for blog cards and listings.
                        </p>

                        <textarea
                            id="summary"
                            name="summary"
                            rows="4"
                            maxlength="2000"
                            placeholder="Give readers a quick preview of the article..."
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('summary', $post->summary ?? '') }}</textarea>

                        @error('summary')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- CATEGORY --}}

                    <div>

                        <label
                            for="category"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Category
                        </label>

                        <input
                            id="category"
                            name="category"
                            type="text"
                            maxlength="255"
                            value="{{ old('category', $post->category ?? '') }}"
                            placeholder="Manga News"
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('category')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- TAGS --}}

                    <div>

                        <label
                            for="tags"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Tags
                        </label>

                        <input
                            id="tags"
                            name="tags"
                            type="text"
                            value="{{
                                old(
                                    'tags',
                                    isset($post) && is_array($post->tags)
                                        ? implode(', ', $post->tags)
                                        : ($post->tags ?? '')
                                )
                            }}"
                            placeholder="manga, anime, indie comics"
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Separate tags with commas.
                        </p>

                        @error('tags')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- STATUS --}}

                    <div>

                        <label
                            for="status"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option
                                value="draft"
                                @selected(
                                    old('status', $post->status ?? 'draft') === 'draft'
                                )
                            >
                                Draft
                            </option>

                            <option
                                value="published"
                                @selected(
                                    old('status', $post->status ?? '') === 'published'
                                )
                            >
                                Published
                            </option>

                        </select>

                        @error('status')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- PUBLISH DATE --}}

                    <div>

                        <label
                            for="published_at"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            Publish Date
                        </label>

                        <input
                            id="published_at"
                            name="published_at"
                            type="datetime-local"
                            value="{{
                                old(
                                    'published_at',
                                    isset($post) && $post->published_at
                                        ? $post->published_at->format('Y-m-d\TH:i')
                                        : ''
                                )
                            }}"
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('published_at')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- FEATURED --}}

                    <div>

                        <input
                            type="hidden"
                            name="is_featured"
                            value="0"
                        >

                        <label
                            class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >

                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                @checked(
                                    old(
                                        'is_featured',
                                        $post->is_featured ?? false
                                    )
                                )
                                class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >

                            <div>

                                <p class="text-sm font-bold text-gray-900">
                                    Featured Article
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Give this post priority placement.
                                </p>

                            </div>

                        </label>

                    </div>



                    {{-- PUBLISHED --}}

                    <div>

                        <input
                            type="hidden"
                            name="is_published"
                            value="0"
                        >

                        <label
                            class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >

                            <input
                                type="checkbox"
                                name="is_published"
                                value="1"
                                @checked(
                                    old(
                                        'is_published',
                                        $post->is_published ?? false
                                    )
                                )
                                class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >

                            <div>

                                <p class="text-sm font-bold text-gray-900">
                                    Publicly Visible
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Allow readers to access this article.
                                </p>

                            </div>

                        </label>

                    </div>



                    {{-- SEO TITLE --}}

                    <div class="md:col-span-2 border-t border-gray-200 pt-6">

                        <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                            SEO
                        </p>

                    </div>


                    <div class="md:col-span-2">

                        <label
                            for="seo_title"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            SEO Title
                        </label>

                        <input
                            id="seo_title"
                            name="seo_title"
                            type="text"
                            maxlength="255"
                            value="{{ old('seo_title', $post->seo_title ?? '') }}"
                            placeholder="Optional search-engine title"
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('seo_title')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- SEO DESCRIPTION --}}

                    <div class="md:col-span-2">

                        <label
                            for="seo_description"
                            class="block text-sm font-semibold text-gray-900"
                        >
                            SEO Description
                        </label>

                        <textarea
                            id="seo_description"
                            name="seo_description"
                            rows="3"
                            maxlength="1000"
                            placeholder="Describe the article for search engines..."
                            class="mt-3 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('seo_description', $post->seo_description ?? '') }}</textarea>

                        @error('seo_description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================
            BLOG MEDIA
        ========================================================= --}}

        <div>

            <div class="mb-3">

                <h3 class="text-sm font-bold text-gray-900">
                    Featured Media
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    Upload a featured image or preview a supporting video.
                </p>

            </div>


            <div
                class="overflow-hidden rounded-2xl border border-dashed border-gray-300 bg-gray-50"
            >

                <div
                    id="media-placeholder"
                    class="flex min-h-[180px] flex-col items-center justify-center p-8 text-center"
                >

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-gray-400 shadow-sm ring-1 ring-gray-200"
                    >
                        🖼️
                    </div>

                    <p class="mt-4 text-sm font-semibold text-gray-600">
                        Your media preview will appear here
                    </p>

                </div>


                <img
                    style="visibility:hidden; display:none;"
                    id="prview"
                    class="mx-auto max-h-[550px] max-w-full object-contain p-4"
                    src=""
                    alt="Blog image preview"
                >


                <video
                    style="visibility:hidden; display:none;"
                    id="vupld"
                    class="mx-auto max-h-[550px] w-full object-contain p-4"
                    controls
                >
                    Your browser does not support the video tag.
                </video>

            </div>

        </div>



        {{-- ========================================================
            ACTION BAR
        ========================================================= --}}

        <div
            class="flex flex-col gap-5 rounded-2xl border border-gray-200 bg-gray-50 p-5 sm:flex-row sm:items-center sm:justify-between"
        >

            <div>

                <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-500">
                    Add Media
                </p>


                <div class="flex flex-wrap items-center gap-3">


                    {{-- FEATURED IMAGE --}}

                    <label
                        for="imgInp"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700"
                    >

                        <span>
                            🖼️
                        </span>

                        Image

                        <input
                            id="imgInp"
                            name="featured_image"
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            class="sr-only"
                        >

                    </label>



                    {{-- VIDEO PREVIEW --}}

                    <label
                        for="featured_video"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700"
                    >

                        <span>
                            🎥
                        </span>

                        Video

                        <input
                            id="featured_video"
                            name="featured_video"
                            type="file"
                            accept="video/*"
                            class="sr-only"
                        >

                    </label>

                </div>


                @error('featured_image')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <button
                id="submit"
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-7 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >

                {{ isset($post->id) ? 'Update Blog' : 'Save Blog' }}

            </button>

        </div>

    </form>

</div>



{{-- ================================================================
    EDITOR CSS
================================================================ --}}

<style>

    .editor-button {
        display: inline-flex;
        min-width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        padding: 0 0.55rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #4b5563;
        transition: all 0.15s ease;
    }

    .editor-button:hover {
        background: #e5e7eb;
        color: #111827;
    }

    .editor-button.is-active {
        background: #4f46e5;
        color: white;
    }

    #tiptap-editor .ProseMirror {
        min-height: 600px;
        padding: 2.5rem;
        outline: none;
        font-size: 1.05rem;
        line-height: 1.85;
        color: #1f2937;
    }

    #tiptap-editor .ProseMirror p {
        margin: 0 0 1.25rem;
    }

    #tiptap-editor .ProseMirror h1 {
        margin-top: 2.25rem;
        margin-bottom: 1rem;
        font-size: 2.25rem;
        line-height: 1.15;
        font-weight: 900;
        color: #111827;
    }

    #tiptap-editor .ProseMirror h2 {
        margin-top: 2rem;
        margin-bottom: 0.9rem;
        font-size: 1.75rem;
        line-height: 1.25;
        font-weight: 800;
        color: #111827;
    }

    #tiptap-editor .ProseMirror h3 {
        margin-top: 1.75rem;
        margin-bottom: 0.8rem;
        font-size: 1.35rem;
        font-weight: 800;
        color: #111827;
    }

    #tiptap-editor .ProseMirror ul {
        margin: 1rem 0 1.5rem 1.5rem;
        list-style-type: disc;
    }

    #tiptap-editor .ProseMirror ol {
        margin: 1rem 0 1.5rem 1.5rem;
        list-style-type: decimal;
    }

    #tiptap-editor .ProseMirror blockquote {
        margin: 2rem 0;
        border-left: 4px solid #dc2626;
        background: #f9fafb;
        padding: 1.25rem 1.5rem;
        font-style: italic;
    }

    #tiptap-editor .ProseMirror a {
        color: #4f46e5;
        text-decoration: underline;
    }

    #tiptap-editor .ProseMirror hr {
        margin: 2.5rem 0;
        border: 0;
        border-top: 1px solid #d1d5db;
    }

    @media (max-width: 640px) {

        #tiptap-editor .ProseMirror {
            padding: 1.25rem;
            min-height: 500px;
        }

    }

</style>



{{-- ================================================================
    TIPTAP
================================================================ --}}

<script type="module">

    import {
        Editor
    } from 'https://esm.sh/@tiptap/core';

    import StarterKit
        from 'https://esm.sh/@tiptap/starter-kit';

    import TextAlign
        from 'https://esm.sh/@tiptap/extension-text-align';


    document.addEventListener('DOMContentLoaded', function () {

        const editorElement =
            document.getElementById('tiptap-editor');

        const postBody =
            document.getElementById('content');

        const postForm =
            document.getElementById('postForm');

        const editorStatus =
            document.getElementById('editor-status');


        if (!editorElement || !postBody) {
            return;
        }


        const editor = new Editor({

            element: editorElement,

            extensions: [

                StarterKit.configure({

                    heading: {
                        levels: [1, 2, 3],
                    },

                }),

                TextAlign.configure({

                    types: [
                        'heading',
                        'paragraph'
                    ],

                }),

            ],

            content:
                postBody.value || '<p></p>',

            editorProps: {

                attributes: {

                    spellcheck: 'true',

                    class:
                        'focus:outline-none',

                },

            },

            onUpdate({ editor }) {

                postBody.value =
                    editor.getHTML();

                if (editorStatus) {

                    editorStatus.textContent =
                        'Changes ready to save';

                }

            },

            onSelectionUpdate() {

                updateToolbar();

            },

            onTransaction() {

                updateToolbar();

            },

        });



        document
            .querySelectorAll('[data-editor-action]')
            .forEach(function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const action =
                            button.dataset.editorAction;

                        switch (action) {

                            case 'paragraph':
                                editor.chain().focus().setParagraph().run();
                                break;

                            case 'h1':
                                editor.chain().focus().toggleHeading({ level: 1 }).run();
                                break;

                            case 'h2':
                                editor.chain().focus().toggleHeading({ level: 2 }).run();
                                break;

                            case 'h3':
                                editor.chain().focus().toggleHeading({ level: 3 }).run();
                                break;

                            case 'bold':
                                editor.chain().focus().toggleBold().run();
                                break;

                            case 'italic':
                                editor.chain().focus().toggleItalic().run();
                                break;

                            case 'underline':
                                editor.chain().focus().toggleUnderline().run();
                                break;

                            case 'strike':
                                editor.chain().focus().toggleStrike().run();
                                break;

                            case 'bulletList':
                                editor.chain().focus().toggleBulletList().run();
                                break;

                            case 'orderedList':
                                editor.chain().focus().toggleOrderedList().run();
                                break;

                            case 'blockquote':
                                editor.chain().focus().toggleBlockquote().run();
                                break;

                            case 'alignLeft':
                                editor.chain().focus().setTextAlign('left').run();
                                break;

                            case 'alignCenter':
                                editor.chain().focus().setTextAlign('center').run();
                                break;

                            case 'alignRight':
                                editor.chain().focus().setTextAlign('right').run();
                                break;

                            case 'horizontalRule':
                                editor.chain().focus().setHorizontalRule().run();
                                break;

                            case 'undo':
                                editor.chain().focus().undo().run();
                                break;

                            case 'redo':
                                editor.chain().focus().redo().run();
                                break;

                        }

                        updateToolbar();

                    }
                );

            });



        const linkButton =
            document.getElementById('editor-link');


        if (linkButton) {

            linkButton.addEventListener(
                'click',
                function() {

                    const previousUrl =
                        editor.getAttributes('link').href;

                    const url =
                        window.prompt(
                            'Enter URL:',
                            previousUrl || 'https://'
                        );

                    if (url === null) {
                        return;
                    }

                    if (url === '') {

                        editor
                            .chain()
                            .focus()
                            .extendMarkRange('link')
                            .unsetLink()
                            .run();

                        return;
                    }

                    editor
                        .chain()
                        .focus()
                        .extendMarkRange('link')
                        .setLink({
                            href: url
                        })
                        .run();

                }
            );

        }



        function updateToolbar() {

            document
                .querySelectorAll('[data-editor-action]')
                .forEach(function(button) {

                    const action =
                        button.dataset.editorAction;

                    let active = false;


                    switch (action) {

                        case 'bold':
                            active = editor.isActive('bold');
                            break;

                        case 'italic':
                            active = editor.isActive('italic');
                            break;

                        case 'underline':
                            active = editor.isActive('underline');
                            break;

                        case 'strike':
                            active = editor.isActive('strike');
                            break;

                        case 'bulletList':
                            active = editor.isActive('bulletList');
                            break;

                        case 'orderedList':
                            active = editor.isActive('orderedList');
                            break;

                        case 'blockquote':
                            active = editor.isActive('blockquote');
                            break;

                        case 'h1':
                            active = editor.isActive('heading', { level: 1 });
                            break;

                        case 'h2':
                            active = editor.isActive('heading', { level: 2 });
                            break;

                        case 'h3':
                            active = editor.isActive('heading', { level: 3 });
                            break;

                        case 'paragraph':
                            active = editor.isActive('paragraph');
                            break;

                    }


                    button.classList.toggle(
                        'is-active',
                        active
                    );

                });

        }



        if (postForm) {

            postForm.addEventListener(
                'submit',
                function() {

                    postBody.value =
                        editor.getHTML();

                }
            );

        }


        window.enterblazeBlogEditor =
            editor;

    });

</script>



{{-- ================================================================
    SETTINGS TOGGLE
================================================================ --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const button =
            document.getElementById('toggle-blog-settings');

        const settings =
            document.getElementById('blog-settings');

        const arrow =
            document.getElementById('blog-settings-arrow');


        if (!button || !settings) {
            return;
        }


        button.addEventListener('click', function () {

            settings.classList.toggle('hidden');

            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }

        });

    });

</script>



{{-- ================================================================
    MEDIA PREVIEW
================================================================ --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const imgInp =
                document.getElementById('imgInp');

            const prview =
                document.getElementById('prview');

            const videoUpload =
                document.getElementById('featured_video');

            const vupld =
                document.getElementById('vupld');

            const placeholder =
                document.getElementById('media-placeholder');


            if (imgInp && prview) {

                imgInp.onchange =
                    function(event) {

                        const file =
                            event.target.files[0];

                        if (!file) {
                            return;
                        }

                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }

                        if (vupld) {
                            vupld.style.display = 'none';
                            vupld.style.visibility = 'hidden';
                        }

                        prview.src =
                            URL.createObjectURL(file);

                        prview.style.display =
                            'block';

                        prview.style.visibility =
                            'visible';

                    };

            }


            if (videoUpload && vupld) {

                videoUpload.onchange =
                    function(event) {

                        const file =
                            event.target.files[0];

                        if (!file) {
                            return;
                        }

                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }

                        if (prview) {
                            prview.style.display = 'none';
                            prview.style.visibility = 'hidden';
                        }

                        const blobURL =
                            URL.createObjectURL(file);

                        vupld.src =
                            blobURL;

                        vupld.style.display =
                            'block';

                        vupld.style.visibility =
                            'visible';

                        vupld.load();

                    };

            }

        }
    );

</script>