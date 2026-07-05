<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardCharacter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_characters';

    protected $fillable = [
        'card_character_name',
        'card_character_alias',
        'card_character_race',
        'card_character_gender',
        'card_character_age',
        'card_character_affiliation',
        'card_character_occupation',
        'card_character_physical',
        'card_character_mental',
        'card_character_spiritual',
        'card_character_abilities',
        'card_character_is_published',

    ];

    protected $dates = ['deleted_at'];


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function universe()
    {
        return $this->belongsTo(Universe::Class, 'card_character_universe_id');
    }
}
