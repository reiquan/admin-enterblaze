<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventLivestream extends Model
{
    protected $table = 'event_livestreams';

    protected $fillable = [
        // Existing event fields...
    
        'event_is_livestream',
        'event_livestream_platform',
        'event_livestream_title',
        'event_livestream_category_id',
    ];

    protected function casts(): array
    {
        return [
            // Existing casts...

            'event_is_livestream' => 'boolean',
            'event_starts_at' => 'datetime',
            'event_ends_at' => 'datetime',
            'event_twitch_synced_at' => 'datetime',
        ];
    }


           /**
     *
     * @param  string  $value
     * @return string
     */
    public function event()
    {
        return $this->belongsTo(Event::Class);
    }
}