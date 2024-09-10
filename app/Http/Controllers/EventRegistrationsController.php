<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Carbon\Carbon;

class EventRegistrationsController extends Controller
{
    //
    public function index(Request $request){
   
        // if(isset($request['candidate']) and $request['candidate']) {
        //     $events = EventAttendance::leftJoin('events', 'events.id', 'event_attendances.event_id')
        //     ->where('event_attendances.candidate_id', $request['candidate'])
        //     ->where('events.deleted_at', NULL)
        //     ->get()
        //     ->unique();
            
        //     // dd($events->toArray());
        //     $candidates = $this->getCandidates($events);
    

    
        //     return view('events/index', compact('events', 'candidates'));
        // }
        
        $event_registrations = EventRegistration::all();



        return view('events/registrations/index', compact('event_registrations'));
    }
    public function show(Request $request){
    
        dd($request->all());
        $event_registration = EventRegistration::find($request->event_registration_id);
      
        return view('events/show', compact('event_registration'));
    }
    public function create(Request $request){
        $event_registration = null;
        $event = Event::find($request->event_id);
    
        $step=isset($request->step) ? $request->step : 1;
        $event_registration_id = null;

  


        // $candidates = Candidate::all();

        if($request->event_registration_id){
            $event_registration = EventRegistration::find($request->event_registration_id);
            $format_start_date = Carbon::parse($event_registration->registration_start_date);
            $event_registration->event_registration_start_date = $format_start_date->format('Y-m-d\TH:i');
            $format_end_date = Carbon::parse($event_registration->registration_registration_end_date);
            $event_registration->event_registration_end_date = $format_end_date->format('Y-m-d\TH:i');

            return view('events/registrations/create', compact( 'event_registration', 'event','step'));
        }

        return view('events/registrations/create', compact('step','event_registration', 'event'));
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
         //validate info
         $request->validate([
            'registration_name' => ['required', 'string', 'max:255'],  
            'registration_description' => ['required', 'string', 'max:255'],             
        ]);
        //save info
                //save universe
                    $event_registration = isset($request->event_registration_id) ? EventRegistration::find($request->event_registration_id) : new EventRegistration;
                        $event_registration->registration_name = $request->registration_name;
                        $event_registration->registration_description = $request->registration_description;
                        $event_registration->registration_type = $request->registration_type;
                        $event_registration->registration_start_date = $request->registration_start_date;
                        $event_registration->registration_end_date = $request->registration_end_date;
                        $event_registration->registration_fee = $request->registration_fee;
                        $event_registration->registration_is_active = 0;
                        $event_registration->registration_event_id = $request->event_id;
                    $event_registration->save();

                $event = Event::find($request->event_id);
        
                return redirect()->route('events.show', ['event_id' => $event->id]);
    }

       /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $step=isset($request->step) ? $request->step : 1;
        $event_registration = EventRegistration::find($request->registration_id);

    //    if(!empty($request->all())){
    //     dd($request->all());
    //    }
        return view('events/registrations/edit', compact('event_registration'));
    } 

    public function update(Request $request){
        
        $event_registration = isset($request->event_registration_id) ? EventRegistration::find($request->registration_id) : new EventRegistration;
            $event_registration->registration_name = $request->registration_name;
            $event_registration->registration_description = $request->registration_description;
            $event_registration->registration_type = $request->registration_type;
            $event_registration->registration_start_date = $request->registration_start_date;
            $event_registration->registration_end_date = $request->registration_end_date;
            $event_registration->registration_fee = $request->registration_fee;
            $event_registration->registration_is_active = 0;
            $event_registration->registration_event_id = $request->event_id;
        $event_registration->save();
 

        $event = Event::find($request->event_id);
        
        return redirect()->route('events.show', ['event_id' => $event->id]);
               
            
           

    }

         /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $event_registration = EventRegistration::find($request->registration_event_id);
        if($request->action == 'publish'){
            $event_registration->registration_is_active = 1;
            $event_registration->save();
        } else {
            $event_registration->registration_is_active = 0;
            $event_registration->save();
        }
       
        return redirect()->route('universe.index');
    }
    
    public function destroy(Request $request){
        $event_registration = EventRegistration::find($request->registration_event_id);
        $event_registration->deleted_at = now();
        $event_registration->save();
        return redirect()->route('events.index');
    }
}