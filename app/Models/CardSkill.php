<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardSkill extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_skills';

    protected $fillable = [
        'card_skill_name',
        'card_skill_element',
        'card_skill_energy_cost',
        'card_skill_character_id',
        'card_skill_cooldown',
        'card_skill_range',
        'card_skill_condition',
        'card_skill_is_active',
        'card_skill_type_id',
        'card_skill_description',
        'card_skill_card_id',
    ];

    protected $dates = ['deleted_at'];


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function card()
    {
        return $this->belongsTo(Card::Class, 'card_skill_card_id');
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
