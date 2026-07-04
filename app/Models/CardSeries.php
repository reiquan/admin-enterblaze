<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'card_series_slug_name',
        'card_series_subtitle',
        'card_series_image_front',
        'card_series_image_back',
        'card_series_price'
    ];

    protected $dates = ['deleted_at', 'card_series_published_at'];


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function cards()
    {
        return $this->hasMany(Card::Class);
    }

    public function era()
    {
        return $this->belongsTo(CardEra::Class);
    }

    public function universe()
    {
        return $this->belongsTo(Universe::Class, 'card_series_universe_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::Class);
    }
}
