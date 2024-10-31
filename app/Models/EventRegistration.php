<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EventRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_registrations';

    protected $fillable = [
        'registration_name',
        'registration_type',
        'registration_event_id',
        'registration_description',
        'registration_start_date',
        'registration_end_date',
        'registration_fee',
        'registration_limit',
        'registration_event_id',
        'registration_is_active',
        'registration_reference_number'

    ];
    protected $dates = [
        'registration_start_date',
        'registration_end_date',
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
     * Get the registrations under this registration type.
     *
     * @param  string  $value
     * @return string
     */
    public function attendances()
    {
        return $this->hasMany(EventRegistrationAttendance::Class, 'event_registration_id');
    }

        /**
     * Get the revent tid to this registration.
     *
     * @param  string  $value
     * @return string
     */
    public function event()
    {
        return $this->belongsTo(Event::Class, 'registration_event_id');
    }

       /**
     *
     * @param  string  $value
     * @return string
     */
    public function getReistrationEndDateAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('lll');
    }
    

    
}
