<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'event_about',
        'event_promo_image',
        'host_user_id',
        'event_address_line_1',
        'event_address_line_2',
        'event_city',
        'event_state',
        'event_zip',
        'event_start_date',
        'event_end_date',
        'attendees',
        'is_active',
        'tags',

    ];
    protected $dates = [
        'event_start_date',
        'event_end_date',
    ];

     /**
     *
     * @param  string  $value
     * @return string
     */
    public function getEventStartDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('lll');
    }
    


     /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function hostUser()
    {
        return $this->belongsTo(User::Class, 'host_user_id');
    }

       /**
     *
     * @param  string  $value
     * @return string
     */
    public function getEventEndDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('lll');
    }
    

    public function volunteers(){
        return $this->hasMany(EventVolunteer::class);
    }
    
}