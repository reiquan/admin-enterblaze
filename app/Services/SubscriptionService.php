<?php

namespace App\Services;

use Illuminate\Http\Request;
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use Mailgun\Mailgun;
use App\Mail\SendAlert;
use App\Models\CandidateSubscriberAlert;
use App\Models\CandidateSubscriber;
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

    public function processAlert($request){
        // dd($request->toArray());
        //get Candidate Subsribers
            // $candidate_subscribers = $this->getCandidateSubscribers(auth()->user()->candidate->id);
            $this->scheduleEmail($request, 'reiquang@yahoo.com');
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

    public function test($request){
        // dd(now()->toIso8601ZuluString(), Carbon::create($request['post_date'])->toIso8601ZuluString());
        // $message = $this->twilioClient->messages
        // ->create(
        //        '+16023868778', // to
        //         [
        //             "messagingServiceSid" => 'MG2d83fa6b983c40b07ae915db947035d7',
        //             'from' => $this->phone_number,
        //             "body" => $request->alert_title . ': '. $request->alert_body,
        //             "sendAt" => Carbon::create($request['post_date'])->toIso8601ZuluString(),
        //             "scheduleType" => "fixed",
        //             // "statusCallback" => "https://webhook.site/xxxxx"
        //         ]
        // );
        dd('done');
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

    public function scheduleEmail($alertInfo, $candidate_subscribers){
        Mail::to('enterblazecomics@gmail.com')->send(new SendAlert($alertInfo));
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