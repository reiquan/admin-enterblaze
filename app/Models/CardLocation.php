<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_locations';

    protected $fillable = [
        'card_location_name',
        'card_location_universe_id',
        'card_location_environment',
        'card_location_region',
        'card_location_bonuses',

    ];

    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function universe()
    {
        return $this->belongsTo(Universe::Class, 'card_location_universe_id');
    }

}
