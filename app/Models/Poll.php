<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question',
        'description',
        'selection_type',
        'maximum_selections',
        'allow_guests',
        'show_results_before_voting',
        'show_results_after_voting',
        'is_published',
        'book_id',
        'issue_id',
        'event_id',
        'card_series_id',
        'card_id',
        'webisode_id',
        'webisode_video_id',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'allow_guests' => 'boolean',
        'show_results_before_voting' => 'boolean',
        'show_results_after_voting' => 'boolean',
        'is_published' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function pollable(): MorphTo
    {
        return $this->morphTo();
    }

    public function universe()
    {
        return $this->belongsTo(Universe::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function cardSeries()
    {
        return $this->belongsTo(CardSeries::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function webisode()
    {
        return $this->belongsTo(Webisode::class);
    }

    public function webisodeVideo()
    {
        return $this->belongsTo(WebisodeVideo::class);
    }


    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class)
            ->orderBy('sort_order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->where(function (Builder $query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    public function isActive(): bool
    {
        if (! $this->is_published) {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->ends_at && $this->ends_at->isPast()) {
            return false;
        }

        return true;
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }
}