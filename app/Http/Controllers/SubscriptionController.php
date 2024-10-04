<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionService;
use App\Models\NotifySubscriberAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    //
    public function __construct(SubscriptionService $alertService){
        $this->alertService = $alertService;
    }

    public function index(){

        // $this->twilio_service->createMessage();
        return;
    }
    public function create(Request $request){

        //if editing existing alert
            //grab alert by id 
        //  $alert;
        // $subscribers = $this->alertService->getCandidateSubscribers(auth()->user()->candidate->id);  
        // dd($subscribers->toArray());
        // return view('candidates/admin/alerts/create', compact('subscribers'));
    }
    public function store(Request $request, NotifySubscriberAlert $alert = null){
        // dd(Carbon::create($request['post_date'])->toRfc1123String()); 
        // $this->alertService->test($request);
        // dd($request->all());
        $candidate_id = auth()->user()->candidate->id;
        // dd($candidate_id);
        //validate request
            $validator = Validator::make($request->all(), [
                'alert_title' => 'required',
                'alert_body' => 'required',
                'alert_type' => 'required',
                // 'alert_attachments' => 'required',
                // 'post_date' => 'required',
            ]);
            if($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
        //save alert in database
            $alertInfo = $this->alertService->saveAlert($request->all(), $candidate_id);
            // dd($alertInfo->toArray());
        //schedule alert on when it is to run
            $this->alertService->processAlert($alertInfo);
        return redirect()->route('candidates.show', [$candidate_id]);
    }


}