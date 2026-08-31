<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'summary',
        'content',
        'featured_image',
        'featured_video',
        'category',
        'tags',
        'status',
        'is_featured',
        'is_published',
        'published_at',
        'views',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Route Binding
    |--------------------------------------------------------------------------
    |
    | Allows:
    |
    | /blogs/my-awesome-post
    |
    | instead of:
    |
    | /blogs/15
    |
    */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /*
    |--------------------------------------------------------------------------
    | Automatically Generate Slug
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {

            if (empty($blog->slug)) {
                $blog->slug = static::generateUniqueSlug(
                    $blog->title
                );
            }

        });

        static::updating(function (Blog $blog) {

            /*
             * Only regenerate the slug if the title changed
             * and you want URLs to follow the new title.
             */

            if (
                $blog->isDirty('title')
                && empty($blog->slug)
            ) {
                $blog->slug = static::generateUniqueSlug(
                    $blog->title,
                    $blog->id
                );
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Unique Slug Generator
    |--------------------------------------------------------------------------
    */

    public static function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {

        $baseSlug = Str::slug($title);

        $slug = $baseSlug;

        $counter = 1;

        while (
            static::query()
                ->when(
                    $ignoreId,
                    fn ($query) =>
                        $query->where('id', '!=', $ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {

            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($query) {

                $query
                    ->whereNull('published_at')
                    ->orWhere(
                        'published_at',
                        '<=',
                        now()
                    );

            });
    }

    public function scopeFeatured($query)
    {
        return $query->where(
            'is_featured',
            true
        );
    }

    public function scopeCategory(
        $query,
        string $category
    ) {
        return $query->where(
            'category',
            $category
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function isPublished(): bool
    {
        if (!$this->is_published) {
            return false;
        }

        if (!$this->published_at) {
            return true;
        }

        return $this->published_at->isPast();
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(
            strip_tags(
                $this->content ?? ''
            )
        );

        /*
         * Average reading speed:
         * roughly 200 words per minute.
         */

        return max(
            1,
            (int) ceil($words / 200)
        );
    }
}