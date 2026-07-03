<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardEra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_factions';

    protected $fillable = [
        'card_faction_name',
        'card_faction_universe_id',
        'card_faction_leader',
        'card_faction_alignment',
        'card_faction_influence',
        'card_faction_military_power',
        'card_faction_wealth',
        'card_faction_territory',
        'card_faction_bonuses',
    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function universe()
    {
        return $this->belongsTo(Universe::Class, 'card_faction_universe_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::Class);
    }


}
