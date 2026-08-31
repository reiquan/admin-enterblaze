<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    /**
     * Display all blog posts.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $status = $request->input('status');

        $blogs = Blog::query()
            ->with('user')

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('summary', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%');

                });

            })

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */
            ->when($category, function ($query) use ($category) {

                $query->where('category', $category);

            })

            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */
            ->when($status, function ($query) use ($status) {

                $query->where('status', $status);

            })

            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Categories for filtering
        |--------------------------------------------------------------------------
        */

        $categories = Blog::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');


        return view('blogs.index', compact(
            'blogs',
            'categories',
            'search',
            'category',
            'status'
        ));
    }


    /**
     * Show blog creation page.
     */
    public function create()
    {
        return view('blogs.create');
    }


    /**
     * Store a new blog post.
     */
    public function store(Request $request)
    {
    
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'summary' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'content' => [
                'required',
                'string',
            ],

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tags' => [
                'nullable',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'is_published' => [
                'nullable',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'seo_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Featured Image
        |--------------------------------------------------------------------------
        */

        $featuredImage = null;

        if ($request->hasFile('featured_image')) {
            $featuredImage = $request
                ->file('featured_image')
                ->store(
                    'blogs/featured-images',
                    's3-public'
                );
        }
        if ($request->hasFile('featured_video')) {
            $featuredImage = $request
                ->file('featured_video')
                ->store(
                    'blogs/featured-videos',
                    's3-public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Tags
        |--------------------------------------------------------------------------
        |
        | Allows the form to send:
        |
        | manga, anime, indie comics
        |
        | The Blog model casts this to an array.
        |
        */

        $tags = $this->prepareTags(
            $request->input('tags')
        );


        /*
        |--------------------------------------------------------------------------
        | Publishing
        |--------------------------------------------------------------------------
        */

        $isPublished =
            $request->boolean('is_published')
            || $validated['status'] === 'published';


        $publishedAt = null;

        if ($isPublished) {

            $publishedAt =
                $validated['published_at']
                ?? now();

        }


        /*
        |--------------------------------------------------------------------------
        | Create Blog
        |--------------------------------------------------------------------------
        */

        $blog = Blog::create([

            'user_id' => auth()->id(),

            'title' => $validated['title'],

            'slug' => Blog::generateUniqueSlug(
                $validated['title']
            ),

            'summary' => $validated['summary'] ?? null,

            'content' => $validated['content'],

            'featured_image' => $featuredImage,

            'category' => $validated['category'] ?? null,

            'tags' => $tags,

            'status' => $validated['status'],

            'is_featured' =>
                $request->boolean('is_featured'),

            'is_published' =>
                $isPublished,

            'published_at' =>
                $publishedAt,

            'views' => 0,

            'seo_title' =>
                $validated['seo_title'] ?? null,

            'seo_description' =>
                $validated['seo_description'] ?? null,

        ]);


        return redirect()
            ->route('blogs.show', $blog->id)
            ->with(
                'success',
                'Blog post created successfully.'
            );
    }


    /**
     * Display a single blog post.
     */
    public function show($blog_id)
    {
        $blog = Blog::with('user')
            ->findOrFail($blog_id);


        // /*
        // |--------------------------------------------------------------------------
        // | Increment Views
        // |--------------------------------------------------------------------------
        // */

        // $blog->incrementViews();


        return view(
            'blogs.show',
            compact('blog')
        );
    }


    /**
     * Show edit page.
     */
    public function edit($blog_id)
    {
        $blog = Blog::findOrFail($blog_id);


        return view(
            'blogs.edit',
            compact('blog')
        );
    }


    /**
     * Update blog post.
     */
    public function update(
        Request $request,
        $blog_id
    ) {

        $blog = Blog::findOrFail($blog_id);


        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'summary' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'content' => [
                'required',
                'string',
            ],

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tags' => [
                'nullable',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'is_published' => [
                'nullable',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'seo_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Featured Image
        |--------------------------------------------------------------------------
        */

        $featuredImage = $blog->featured_image;


        if ($request->hasFile('featured_image')) {

            /*
             * Delete old image.
             */

            if ($blog->featured_image) {

                Storage::disk('s3-public')
                    ->delete(
                        $blog->featured_image
                    );
            }


            /*
             * Store new image.
             */

            $featuredImage = $request
                ->file('featured_image')
                ->store(
                    'blogs/featured-images',
                    's3-public'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Tags
        |--------------------------------------------------------------------------
        */

        $tags = $this->prepareTags(
            $request->input('tags')
        );


        /*
        |--------------------------------------------------------------------------
        | Publishing
        |--------------------------------------------------------------------------
        */

        $isPublished =
            $request->boolean('is_published')
            || $validated['status'] === 'published';


        if ($isPublished) {

            $publishedAt =
                $validated['published_at']
                ?? $blog->published_at
                ?? now();

        } else {

            $publishedAt = null;

        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $blog->update([

            'title' =>
                $validated['title'],

            /*
             * Keep existing slug unless title changes.
             */

            'slug' =>
                $blog->title !== $validated['title']
                    ? Blog::generateUniqueSlug(
                        $validated['title'],
                        $blog->id
                    )
                    : $blog->slug,

            'summary' =>
                $validated['summary'] ?? null,

            'content' =>
                $validated['content'],

            'featured_image' =>
                $featuredImage,

            'category' =>
                $validated['category'] ?? null,

            'tags' =>
                $tags,

            'status' =>
                $validated['status'],

            'is_featured' =>
                $request->boolean('is_featured'),

            'is_published' =>
                $isPublished,

            'published_at' =>
                $publishedAt,

            'seo_title' =>
                $validated['seo_title'] ?? null,

            'seo_description' =>
                $validated['seo_description'] ?? null,

        ]);


        return redirect()
            ->route(
                'blogs.show',
                $blog->id
            )
            ->with(
                'success',
                'Blog post updated successfully.'
            );
    }


    /**
     * Delete blog post.
     */
    public function destroy($blog_id)
    {
        $blog = Blog::findOrFail($blog_id);


        /*
        |--------------------------------------------------------------------------
        | Delete Featured Image
        |--------------------------------------------------------------------------
        */

        if ($blog->featured_image) {

            Storage::disk('s3-public')
                ->delete(
                    $blog->featured_image
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Delete Blog
        |--------------------------------------------------------------------------
        */

        $blog->delete();


        return redirect()
            ->route('blogs.index')
            ->with(
                'success',
                'Blog post deleted successfully.'
            );
    }


    /**
     * Convert comma-separated tags into an array.
     */
    private function prepareTags($tags): array
    {
        if (empty($tags)) {
            return [];
        }


        /*
         * Already an array.
         */

        if (is_array($tags)) {

            return collect($tags)
                ->map(
                    fn ($tag) =>
                        trim($tag)
                )
                ->filter()
                ->unique()
                ->values()
                ->toArray();

        }


        /*
         * Comma separated string.
         *
         * Example:
         *
         * manga, anime, indie comics
         */

        return collect(
            explode(',', $tags)
        )
            ->map(
                fn ($tag) =>
                    trim($tag)
            )
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }
}