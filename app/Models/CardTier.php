<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_tiers';

    protected $fillable = [
        'card_tier_name',
        'card_tier_skill_points',
    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function card()
    {
        return $this->belongsTo(Card::Class, 'card_tier_id');
    }

}
