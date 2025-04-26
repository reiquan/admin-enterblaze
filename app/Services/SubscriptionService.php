<?php

namespace App\Services;

use Illuminate\Http\Request;
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Mailgun\Mailgun;
use App\Mail\SendAlert;
use App\Models\EventRegistration;
use App\Mail\SendNewArtistAlert;
use App\Mail\SendNewParticipantAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;


class SubscriptionService
{
    
    public function __construct(){

        $this->twilioClient = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        $this->phone_number = config('services.twilio.from');
        // $this->mailgunClient = Mailgun::create(env('MAILGUN_PRIVATE_API_KEY'), 'https://'.env('MAIL_HOST'));
        $this->mailgunClient = Mailgun::create(config('services.mailgun.private_api_key'), 'https://'.config('services.mailgun.host'));

    }

    public function processAlert($request, $email, $alert_type = null){
        // dd($request);
        //get Candidate Subsribers
            // $candidate_subscribers = $this->getCandidateSubscribers(auth()->user()->candidate->id);
            if($alert_type == 'new_artist'){
                $this->scheduleEmail($request, $email, 'new_artist');
            } else if($alert_type == 'new_participant') {
                $this->scheduleEmail($request, $email, 'new_participant');
            } else {
                $this->scheduleEmail($request, $email);
            }

            // dd($candidate_subscribers->toArray());
        //if $alert_type is email
            // if($request->alert_type == 'email'){                                //if $alert_type is email
            //      //send Email
            //     $this->scheduleEmail($request, $candidate_subscribers);
            // } else if($request->alert_type == 'text'){                           //if $alert_type is text
            //     $this->scheduleTextMessage($request, $candidate_subscribers);    //send text
            // } else {
            //     $this->scheduleTextMessage($request, $candidate_subscribers); 
            //     $this->scheduleEmail($request, $candidate_subscribers);   //Send both email and text
            // }
    }

    public function saveAlert($request, $candidate_id){
        $send_now = $request['post_date'] ?  0 : 1;
    
       $alertInfo = CandidateSubscriberAlert::create([
        'candidate_id' => $candidate_id,
        'alert_title' => $request['alert_title'],
        'alert_body' => $request['alert_body'],
        'alert_type' => $request['alert_type'],
        'alert_attachments' => isset($request['alert_attachments']) ? $request['alert_attachments'] : null,
        'post_date' => $request['post_date'] ? : now()->toDateTimeString(),
       ]);
       $alertInfo->send_now = $send_now;
       return $alertInfo;
    }

    public function updateSubscriber($user_id, $candidate_id, $sub_type, $unsubscribe = 0){

        // dd($user_id, $candidate_id, $sub_type, $unsubscribe);

       $subInfo = CandidateSubscriber::updateOrCreate(
        [
        'user_id' => $user_id,
        'candidate_id' => $candidate_id
        ],
        [
        'candidate_id' => $candidate_id,
        'subscription_type' => $sub_type,
        'is_active' => $unsubscribe ? 0 : 1,
       ]);

       return $subInfo;
    }

    public function formatPhoneNumber($number){

        if(!$number){
            return;
        }
        $instance = PhoneNumberUtil::getInstance();
        $new = $instance->parse($number, "US");
        $formatted_number = $instance->format($new, PhoneNumberFormat::E164);
        return $formatted_number;
    }

    public function getCandidateSubscribers($candidate_id){
        $candidate_list = CandidateSubscriber::where('candidate_id', $candidate_id)->get();
        return $candidate_list;
    }

    public function scheduleTextMessage($alertInfo, $candidate_subscribers){
        // public function scheduleTextMessage($request, $candidate_subscribers = null){
        // dd($this->client); //   WORKS CORRECTLY 11/6
            // dd(Carbon::create($alertInfo['post_date'])->toRfc1123String());
        // dd($candidate_subscribers->toArray());
        foreach($candidate_subscribers as $subscriber){
            // dd($alertInfo->send_now);
            //Send Now
            if (!$subscriber->user->phone_number){
                continue;
            }
            // dd('yo');
    
            if($alertInfo->send_now == 1){
                $this->twilioClient->messages->create(
                    // the number you'd like to send the message to
                    $subscriber->user->phone_number, 
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => $this->phone_number,
                        // the body of the text message you'd like to send
                        'body' => $alertInfo->alert_title . ': '. strip_tags($alertInfo->alert_body),
                    ]
                ); 
                    // print($message->sid);
            } else {
                //Send Later
                $message = $this->twilioClient->messages
                ->create(
                    $subscriber->user->phone_number, // to
                    // '+16023868778',
                        [
                            "messagingServiceSid" => env('TWILIO_MESSAGING_SERVICE_SID'),
                            'from' => $this->phone_number,
                            "body" => $alertInfo->alert_title . ': '. strip_tags($alertInfo->alert_body),
                            "sendAt" => Carbon::create($alertInfo['post_date'])->toIso8601ZuluString(),
                            "scheduleType" => "fixed",
                            // "statusCallback" => "https://webhook.site/xxxxx"
                        ]
                );
            } 
        }
        return;
    }
    public function sendAdminAlert($candidate_name, $candidate_phone_number, $category){
        //array of admin numbers
        // $admin_numbers = [
        //     config('services.twilio.from'),
        // ];
        //foreach number
        if($category == 'Thank You For Your Purchase'){
            // foreach($admin_numbers as $number){
                //send a text message
                $this->twilioClient->messages->create(
                   // the number you'd like to send the message to
                   $candidate_phone_number, 
                   [
                       // A Twilio phone number you purchased at twilio.com/console
                       'from' => $this->phone_number,
                       // the body of the text message you'd like to send
                       'body' => "Thank You For Your Purchase ". $candidate_name 
                   ]
               ); 
        //    }
        }
       return;
           
    }

    public function createBody($body, $type){
        if($type == 'event_receipt'){
           $alert_body =  [ 
                'alert_title' => 'Badge Purchased! ',
                'alert_body' => 'Confirmation #:'. $body['attendee_receipt_number'],
            ];

            return $alert_body;

        } else  if($type == 'tournament_entry'){
            $registration = EventRegistration::find($body['event_registration_id']);
            
            $alert_body =  [ 
                 'alert_title' => 'You are now scheduled to Participate in **'. $registration->event->event_name.'**',
                 'alert_receipt' => 'Reservation #: '. $body['attendee_receipt_number'],
                 'alert_body' => 'Please follow the link below on any updates to the upcoming tournament starting at '.$registration->registration_start_date.' **WARNING** Faiure to show up on time is an automatic forfeit so please make sure to show up',
                 'alert_link' => 'https://discord.gg/',

             ];
 
             return $alert_body;

         } else  if($type == 'reservation'){
            
            $alert_body =  [ 
                 'alert_title' => 'Reservation made! ',
                 'alert_body' => 'Reservation #:'. $body['reservation_number'],
             ];
 
             return $alert_body;

         } else if('artist_request'){
            $alert_body =  [ 
                'alert_title' => 'You Have a New Artist Request!',
                'alert_body' =>  $body['name']. ' wants to join the artist platform',
                'alert_portfolio_url' => $body['portfolio_url']
            ];

            return $alert_body;
         }
    }

    public function scheduleEmail($alertInfo, $email, $type = null){

       if(isset($type) && $type == 'new_artist') {
             Mail::to($email)->send(new SendNewArtistAlert($alertInfo));
       } else if(isset($type) && $type == 'new_participant') {
            Mail::to($email)->send(new SendNewParticipantAlert($alertInfo));
       } else {
            Mail::to($email)->send(new SendAlert($alertInfo));
       }
        // foreach($candidate_subscribers as $subscriber){
        //     if($alertInfo->send_now){
        //          //OR
        //         //Send right away
        //         $alertInfo->candidate = auth()->user()->candidate->name;
        //         Mail::to($subscriber->user->email)->send(new SendAlert($alertInfo));
        //     } else {
        //         //Schedule sending
        //         $domain = "https://www.kyvi.io";
        //         $params = array(
        //             'from'           => auth()->user()->candidate->name.config('mail.from.address'),
        //             'to'             => $subscriber->user->email,
        //             'subject'        => $alertInfo->alert_title,
        //             'text'           => $alertInfo->alert_body,
        //             'o:deliverytime' => Carbon::create($request['post_date'])->toIso8601ZuluString()
        //         );

        //         # Make the call to the client.
        //         $result = $this->mailgunClient->messages()->send($domain, $params);
        //     }
        // }
        return;
    }
    
}