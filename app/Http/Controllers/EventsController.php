<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\User;

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
        // dd($event_id);
   
        $events = Event::where('host_user_id', auth()->user()->id)->get();
      
        $is_host = auth()->user()->id == $event[0]['host_user_id'];
        
        // dd($old_candidates->toArray(), $candidates->toArray());
        return view('events/show', compact('event', 'is_host'));
    }
    public function create(Request $request){
        $event = null;
        
      if($request->step){
        $event= Event::find($request->event);
      }

        $attendees = null;
        $step=isset($request->step) ? $request->step : 1;
        $event_id = null;
        // $candidates = Candidate::all();

        if($request->event_id){
            $event = Event::find($request->event_id);
            // $attendees = $this->getCandidates($event, 'single');
            // return view('events/create', compact('candidates', 'event', 'attendees'));
            return view('events/create', compact( 'event'));
        }

        return view('events/create', compact('step','event', 'attendees', 'event_id'));
    }
    public function update(Request $request){
        
      
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
                $event->attendees = json_encode($request->attendees);
                $event->is_active = 1;
                // $event->tags = json_encode($request->tags);
            $event->save();
            foreach($request->attendees as $attendee){
                $this->candidateSubmit($attendee, $event->id);
            }
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
                return redirect()->route('events.edit', ['event' => $event, 'step' => $step]);
            } else {
                return redirect()->route('events.create', ['event' => $event, 'step' => $step]);
            }
               
            
           

        }
    }
    // public function attendeeSubmit(Request $request, $event_id){
    
    //    if($request->is_not_attending){
    //         $user = User::find($request->user_id);
    //         $event = Event::find($event_id);
    //         $attendee =EventAttendance::where('user_id', $request->user_id)
    //                                     ->where('event_id', $event->id)
    //                                     ->first();
    //         if(!$attendee){
    //             $attendee =EventAttendance::where('candidate_id', $request->user_id)
    //                                         ->where('event_id', $event->id)
    //                                         ->first();
    //         }
    //         if($attendee){
    //             $new = [];
    //             $old = json_decode($event->attendees);
              
    //             foreach($old as $o){
    //                 if($o == $request->user_id){
    //                     continue;
    //                 } else {
    //                     array_push($new, $o);
    //                 }
    //             }
    //             $event->attendees = json_encode($new);
    //             $event->save();
    //             $attendee->deleted_at = now();
    //             $attendee->save();
    //         }
    //                     // dd( $attendee->toArray(), $event_id);
    //    } else {
    //         $user = User::find($request->user_id);
    //         $event = Event::find($event_id);
    //         $attendee = new EventAttendance;
    //             $attendee->event_id = $request->event_id;
    //             $attendee->user_id = $request->user_id;
    //         $attendee->save();
    //    }
        
            
    //     // send to users dashboard where they can then email the governor as a way to filter the BS
    //     return redirect()->route('home');
    // }

    // public function candidateSubmit($att, $event_id){
    //     // dd($att, $event_id);
    //         //Automatically add host candidate
    //         $candidate = Candidate::find($att);
    //         $event = Event::find($event_id);
    //         $attendee = new EventAttendance;
    //             $attendee->event_id = $event_id;
    //             $attendee->candidate_id = $att;
    //         $attendee->save();
        
            
    //     // send to users dashboard where they can then email the governor as a way to filter the BS
    //     return redirect()->route('home');
    // }
    
    // public function destroy(Request $request, $event_id){
    //     $event = Event::find($event_id);
    //     $event->deleted_at = now();
    //     $event->save();
    //     return redirect()->route('home');
    // }
    // public function getCandidates($events, $single = null){
    //     $attendees = collect();
    //     if($single){
           
    //         $candidates = json_decode($events->attendees);
            
    //         if($candidates){
    //             foreach($candidates as $candidate){
    //                 $c = Candidate::find(intval($candidate));
    //                 if(isset($c)) {
                    
    //                     $attendees->push($c);
    //                 }
    //             }
    //         }
    //         return $attendees;
    //     }
    //     foreach($events as $event){
    //         $candidates = json_decode($event->attendees);
            
    //         if($candidates){
    //             foreach($candidates as $candidate){
    //                 $c = Candidate::find(intval($candidate));
    //                 if(isset($c) and $c){
    //                     $c->event_id = $event->id;
    //                     $attendees->push($c);
    //                 }
    //             }
    //         }
    //     }

    //     return $attendees;
    // }
}