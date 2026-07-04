<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_types';

    protected $fillable = [
        'card_type_name',
        'card_type_description',
        'card_type_is_active',
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
        return $this->belongsTo(Card::Class, 'card_type_id');
    }

}
