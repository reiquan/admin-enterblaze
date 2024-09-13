<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ValidationService
{
    

      /**
     * check if page exists
     */
    public function validateInput($array)
    {
      $fields = $this->getRequiredRegistrationFields($array);
        if(!is_array($fields)){
            return $fields;
        }
      foreach($fields as $key => $value){
        $sanitize = $this->sanitizeData($key, $value);
        if(empty($sanitize)){
            continue;
        } else {
            return $sanitize;
        }
      }
      return;
    }

    public function getRequiredRegistrationFields($array)
    {

      if($array['event_registration_id'] == '1' || $array['event_registration_id'] == '2' || $array['event_registration_id'] == '3') {
        $required = [
        'attendee_first_name',
        'attendee_last_name',
        'attendee_email',
        'attendee_phone_number',
        'event_registration_id',
        'attendee_company_name',
        'attendee_company_description',
        'attendee_company_url',
        'attendee_number_of_employees_attending',
        'attendee_receipt_number',
        'attendee_charge',
        'acknowledgement_of_no_refunds'
        ];
        foreach($array as $key => $value){
           if(in_array($key, $required)){
            continue;
           } else {
            return 'missing '. $key . ' field';
           }
        }
        return $required;

      } else if($array['event_registration_id'] == '4') {
        $required = [
            'attendee_first_name',
            'attendee_last_name',
            'attendee_email',
            'attendee_phone_number',
            'attendee_receipt_number',
            'event_registration_id',
            'attendee_charge',
            'acknowledgement_of_no_refunds'
        ];
        foreach($array as $key => $value){
            if(in_array($key, $required)){
             continue;
            } else {
             return 'missing '. $key . ' field';
            }
         }
         return $required;
      } else {
        return 'No details found for this event';
      }
    }

    public function sanitizeData($key, $value){
        if(stristr($key, 'email')){
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
               return;
            } else {
                return "The email address is invalid.";
            }
        } else if(stristr($key, 'phone_number')) {
            if (preg_match("/^(\(\d{3}\)\s?|\d{3}-?)\d{3}-?\d{4}$/", $value)) {
                return;
            } else {
                return "The phone number is invalid.";
            }
        } else {
            return;
        }
    }

    
}