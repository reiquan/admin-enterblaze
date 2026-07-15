<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebisodeVideo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'webisode_videos';

    protected $fillable = [
        'webisode_id',

        'video_title',
        'video_slug',
        'video_description',

        'video_number',
        'video_sort_order',

        'video_path',
        'video_thumbnail',
        'video_trailer_path',

        'video_mime_type',
        'video_file_size',
        'video_duration_seconds',

        'video_is_published',
        'video_is_featured',
        'video_is_locked',

        'video_publish_at',

        'video_is_free',
        'video_blaze_token_cost',
        'video_price',

        'video_rating',
        'video_is_adult',

        'video_tags',

        'video_view_count',
        'video_like_count',
        'video_comment_count',

        'video_provider',
        'video_external_id',
        'video_embed_url',
    ];

    protected $casts = [
        'video_tags' => 'array',
        'video_publish_at' => 'datetime',
    
        'video_is_free' => 'boolean',
        'video_is_locked' => 'boolean',
        'video_is_featured' => 'boolean',
        'video_is_published' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function webisode()
    {
        return $this->belongsTo(Webisode::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedDurationAttribute()
    {
        if (!$this->video_duration_seconds) {
            return null;
        }

        return gmdate(
            $this->video_duration_seconds >= 3600 ? 'H:i:s' : 'i:s',
            $this->video_duration_seconds
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('video_is_published', true);
    }

    public function scopeUnlocked($query)
    {
        return $query->where('video_is_locked', false);
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('video_sort_order')
            ->orderBy('video_number');
    }
}