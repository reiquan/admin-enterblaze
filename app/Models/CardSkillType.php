<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSkillType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_skill_types';

    protected $fillable = [
        'card_skill_type_name',
    ];


         /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function skill()
    {
        return $this->belongsTo(CardSkill::Class, 'card_skill_type_id');
    }

}
