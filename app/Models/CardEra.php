<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardEra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_eras';

    protected $fillable = [
        'card_era_name',
        'card_era_description',
        'card_era_power_scale_multiplier',
    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function series()
    {
        return $this->belongsTo(CardSeries::Class, 'card_era_id');
    }

}
