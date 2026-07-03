<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_skills';

    protected $fillable = [
        'card_skill_name',
        'card_skill_element',
        'card_skill_energy_cost',
        'card_skill_cooldown',
        'card_skill_range',
        'card_skill_type_id',
        'card_skill_description',
    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function card()
    {
        return $this->belongsTo(Card::Class, 'card_skill_id');
    }
    public function character()
    {
        return $this->belongsTo(CardCharacter::Class);
    }
    public function type()
    {
        return $this->hasOne(CardType::Class, 'card_skill_type_id');
    }

}
