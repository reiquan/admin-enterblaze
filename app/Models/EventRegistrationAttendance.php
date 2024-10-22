<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EventRegistrationAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_registration_attendances';

    protected $fillable = [
        'attendee_first_name',
        'attendee_last_name',
        'attendee_email',
        'attendee_handle_type',
        'attendee_handle_name',
        'attendee_phone_number',
        'event_registration_id',
        'attendee_company_name',
        'attendee_company_description',
        'attendee_company_url',
        'attendee_number_of_employees_attending',
        'acknowledgement_of_no_refunds',
        'attendee_receipt_number',
        'attendee_charge',
        'is_active',


    ];




     /**
     * Get the registration that belongs to this.
     *
     * @param  string  $value
     * @return string
     */
    public function registration()
    {
        return $this->belongsTo(EventRegistration::Class, 'event_registration_id');
    }
    
}
