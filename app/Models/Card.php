<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cards';

    protected $fillable = [
        'card_name',
        'card_type_id',
        'card_character_id',
        'card_location_id',
        'card_faction_id',
        'card_tier_id',
        'card_series_id',
        'card_slug',
        'card_era_id',
        'card_rarity',
        'card_bio',
        'card_image_one',
        'card_image_two',
        'card_is_published',
        'card_tags',
        'card_bio'
    ];
    protected $dates = ['deleted_at'];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function character()
    {
        return $this->belongsTo(CardCharacter::Class, 'card_character_id');
    }

    public function faction()
    {
        return $this->belongsTo(CardFaction::Class, 'card_faction_id');
    }

    public function location()
    {
        return $this->belongsTo(CardLocation::Class, 'card_location_id');
    }
    public function type()
    {
        return $this->belongsTo(CardType::Class, 'card_type_id');
    }
    public function tier()
    {
        return $this->belongsTo(CardTier::Class, 'card_tier_id');
    }
    public function era()
    {
        return $this->belongsTo(CardEra::Class, 'card_tier_id');
    }
    public function series()
    {
        return $this->belongsTo(CardSeries::Class, 'card_tier_id');
    }
}
