<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\User;
use Carbon\Carbon;

class EventsController extends Controller
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
        
        $events = Event::all();



        return view('events/index', compact('events'));
    }
    public function show(Request $request){
    
   
        $event = Event::find($request->event_id);
      
        // $is_host = auth()->user()->id == $event['host_user_id'];
        
        // dd($old_candidates->toArray(), $candidates->toArray());
        return view('events/show', compact('event'));
    }
    public function create(Request $request){
        // dd($request->all());
        $event = null;

        $attendees = null;
        $step=isset($request->step) ? $request->step : 1;
        $event_id = null;

  


        // $candidates = Candidate::all();

        if($request->event_id){
            $event = Event::find($request->event_id);
            $format_start_date = Carbon::parse($event->event_start_date);
            $event->event_start_date = $format_start_date->format('Y-m-d\TH:i');
            $format_end_date = Carbon::parse($event->event_end_date);
            $event->event_end_date = $format_end_date->format('Y-m-d\TH:i');
            // $attendees = $this->getCandidates($event, 'single');
            // return view('events/create', compact('candidates', 'event', 'attendees'));
            return view('events/create', compact( 'event', 'step'));
        }

        return view('events/create', compact('step','event', 'attendees', 'event_id'));
    }

       /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $step=isset($request->step) ? $request->step : 1;
        $event = Event::find($id);
        $event_id = $event->id;
    
            $event->event_start_date = Carbon::parse($event->event_start_date)->toDateTime();
           
            $event->event_end_date = Carbon::parse($event->event_end_date)->toDateTime();
    //    if(!empty($request->all())){
    //     dd($request->all());
    //    }
        return view('events/edit', compact('event', 'step','event_id'));
    } 

    public function update(Request $request){
        
    //   dd($request->all());
       if($request->event_id){
            $event = Event::find($request->event_id);
                $event->event_name = $request->event_name;
                $event->event_about = $request->event_about;
                $event->host_user_id = auth()->user()->id;
                $event->event_address_line_1 = $request->event_address_line_1;
                $event->event_address_line_2 = $request->event_address_line_2;
                $event->event_city = $request->event_city;
                $event->event_state = $request->event_state;
                $event->event_zip = $request->event_zip;
                $event->event_start_date = $request->event_start_date;
                $event->event_end_date = $request->event_end_date;
                $event->is_active = 1;
                // $event->tags = json_encode($request->tags);
            $event->save();
        
       } else {
            $event = new Event;
                $event->event_name = $request->event_name;
                $event->event_about = $request->event_about;
                $event->host_user_id = auth()->user()->id;
                $event->event_address_line_1 = $request->event_address_line_1;
                $event->event_address_line_2 = $request->event_address_line_2;
                $event->event_city = $request->event_city;
                $event->event_state = $request->event_state;
                $event->event_zip = $request->event_zip;
                $event->event_start_date = $request->event_start_date;
                $event->event_end_date = $request->event_end_date;
                $event->attendees = json_encode($request->attendees);
                $event->is_active = 1;
                // $event->tags = json_encode($request->tags);
            $event->save();
            //Autmatically add host/candidate
            // if(isset(auth()->user()->candidate->id)){
            //     // $host = Candidate::find(intval(auth()->user()->candidate->id));
            //     $this->candidateSubmit($host->id,$event->id);
            // }
            // if(isset($request->attendees)){
            //     // dd($request->attendees);
            //     foreach($request->attendees as $attendee){
            //         $this->candidateSubmit($attendee, $event->id);
            //     }
            // }
       }
         //if request->step == 4
         if($request->step == 4){
        
            return view('universe.index');
           

        } else {
            
 
            $step = $request->step += 1;

            if(isset($request->type) && $request->type == 'edit'){
                return redirect()->route('events.edit', ['event_id' => $event->id, 'step' => $step]);
            } else {
                return redirect()->route('events.create', ['event' => $event, 'step' => $step]);
            }
               
            
           

        }
    }

         /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $event = Event::find($id);
        if($request->action == 'publish'){
            $event->is_active = 1;
            $event->save();
        } else {
            $event->is_active = 0;
            $event->save();
        }
       
        return redirect()->route('universe.index');
    }
    
    public function destroy(Request $request){
        $event = Event::find($request->event_id);
        $event->deleted_at = now();
        $event->save();
        return redirect()->route('events.index');
    }
}