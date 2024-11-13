<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Models\EventRegistrationAttendance;

class EventRegistrationAttendancesController extends Controller
{
    //
    public function __construct(StripeService $stripeService){
        $this->stripeService = $stripeService;
    }

    public function create(Request $request){
       
            $event_registration = null;
    
            $event_registration_id = null;
            $event_registration = EventRegistration::find($request->event_registration_id);
            $format_start_date = Carbon::parse($event_registration->registration_start_date);
            $event_registration->event_registration_start_date = $format_start_date->format('Y-m-d\TH:i');
            $format_end_date = Carbon::parse($event_registration->registration_registration_end_date);
            $event_registration->event_registration_end_date = $format_end_date->format('Y-m-d\TH:i');

            return view('events/registrations/attendances/create', compact( 'event_registration', 'event','step'));

    }

    public function store(Request $request)
    {

         $request->validate([
            'attendee_first_name' => 'required',
            'attendee_last_name' => 'required',
            'attendee_email' => 'required',
            'attendee_handle_type' => 'required',
            'attendee_handle_name' => 'required',
            'attendee_phone_number' => 'required',
            'attendee_receipt_number' => 'required',
            'attendee_charge' => 'required',        
        ]);
        //save info
                //save universe
                    $event_registration_attendance = isset($request->event_registration_id) ? EventRegistration::find($request->event_registration_id) : new EventRegistration;
                        $event_registration_attendance->attendee_first_name = $request->attendee_first_name;
                        $event_registration_attendance->attendee_last_name = $request->attendee_last_name;
                        $event_registration_attendance->attendee_email = $request->attendee_email;
                        $event_registration_attendance->attendee_handle_type = $request->attendee_handle_type;
                        $event_registration_attendance->attendee_handle_name = $request->attendee_handle_name;
                        $event_registration_attendance->attendee_phone_number = $request->attendee_phone_number;
                        $event_registration_attendance->event_registration_id = $request->event_registration_id;
                        $event_registration_attendance->attendee_status = 'Competing';
                        $event_registration_attendance->attendee_charge = $request->attendee_charge;
                        $event_registration_attendance->attendee_receipt_number = $request->attendee_receipt_number;
                    $event_registration_attendance->save();

                
        
                return redirect()->route('events.registrations.show', ['registration_id' => $event_registration_attendance->event_registration_id]);
    }

    public function changeStatus(Request $request){

           
            $event_registration_attendee = EventRegistrationAttendance::find($request->attendance_id);
            $event_registration_attendee->attendee_status = $request->status;
            $event_registration_attendee->save();

            return;

    }

    public function payoutReward(Request $request){

        //    dd($request->all());
        $champion = EventRegistrationAttendance::find($request->attendance_id);
        $amount = 0;

        foreach($champion->registration->attendances as $prize_money){
            $amount += $prize_money->attendee_charge;
        }

        

        $cut = $amount * .40;

        $prize = $amount - $cut;

        $total = ($prize - $champion->attendee_charge );

      

        $b = $this->stripeService->payoutParticipant($champion->attendee_receipt_number, $total);

        dd($b);

        return;

    }
    
    
}
