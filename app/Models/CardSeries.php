<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSeries extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_series';

    protected $fillable = [
        'card_series_name',
        'card_series_universe_id',
        'card_series_book_id',
        'card_series_description_id',
        'card_series_is_active',
    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function cards()
    {
        return $this->hasMany(Card::Class, 'card_character_id');
    }

    public function universe()
    {
        return $this->belongsTo(Universe::Class, 'card_faction_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::Class, 'card_faction_id');
    }
}
