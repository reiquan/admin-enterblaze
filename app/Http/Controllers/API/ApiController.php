<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Universe;
use App\Models\Issue;
use App\Models\Reservation;
use App\Services\BookService;
use App\Services\StripeService;
use App\Services\ValidationService;
use App\Services\SubscriptionService;
use App\Models\IssuePage;
use App\Models\Book;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRegistrationAttendance;
use App\Models\BlazeTokenTier;

class ApiController extends Controller
{
 
    
    public function __construct(ValidationService $validationService, StripeService $stripeService, SubscriptionService $alertService){
        $this->validationService = $validationService;
        $this->stripeService = $stripeService;
        $this->alertService = $alertService;
    }
    public function getUniverses(Request $request)
    {
     
        if(isset($request->universe_id)) {
            return response()
                ->json(Universe::where('universe_is_active', 1)
                ->where('id', $request->universe_id)
                ->with('books.issues')
                ->get()
                ->makeHidden(
                    [
                        'deleted_at',
                        'created_at',
                        'universe_is_active',
                        'universe_user_id'
                    ]
                )->toArray(), 200);
        }
        return response()
                ->json(Universe::where('universe_is_active', 1)
                ->get()
                ->makeHidden(
                    [
                        'deleted_at',
                        'created_at',
                        'universe_is_active',
                        'universe_user_id'
                    ]
                )->toArray(), 200);
    }

    public function getBooks(Request $request)
    {
       
        if(isset($request->universe_id)) {
            return response()
                ->json(Book::where('is_active', 1)
                ->where('book_universe_id', $request->universe_id)
                ->with('issues')
                ->get()
                ->makeHidden(
                    [
                        'deleted_at',
                        'created_at',
                        'is_active',
                      
                    ]
                )->toArray(), 200);
        }
        return response()
                ->json(Book::all()
                ->load('issues')
                ->makeHidden(
                    [
                        'created_at',
                    ]
                )->toArray(), 200);
    }

    public function getChapters(Request $request)
    {
        $pages = IssuePage::where('issue_id', $request->issue_id)->with('issue')->get();
        $issue = Issue::where('issue_book_id', $pages[0]['issue']['issue_book_id'])
                        ->orderBy('issue_number')
                        ->get();    
        $pages->put('chapters', $issue); 

        return response()
                ->json($pages, 
                200
               );
    }

    public function getEvents(Request $request){
        
        $events = Event::where('is_active', 1)
        ->first();
        $data = $request->all();
 
        return response()
            ->json([
                'status' => 'success',
                'data' => $events,
            ], 
            200
        );
 
     }

    public function getOpenRegistrations(Request $request){
        
       $registrations = EventRegistration::where('registration_is_active', 1)
       ->where('id', $request->registration_id)
       ->where('registration_event_id', $request->registration_event_id)
       ->with('event')
       ->first();
       $data = $request->all();

        if(isset($request->registration_event_id) && !empty($registrations->toArray())) {
            return response()
                ->json([
                    'status' => 'success',
                    'data' => $registrations,
                ], 
                200
            );
        } else {
            return response()
                ->json([
                    'status' => 'error',
                    'message' => 'Could Not Find Any Events',
                    'data' => $data,
                ], 
                400
            );
        }

    }

    public function submitOpenRegistrationAttendance(Request $request){

    //     return response()
    //     ->json([
    //         'status' => 'test',
    //         'message' => $request->all(),
    //     ], 
    //     200
    // );
        $validation = $this->validationService->validateInput($request->toArray());

        // if(!$validation){
            $receipt_already_verified = EventRegistrationAttendance::where('attendee_receipt_number', $request->attendee_receipt_number)->first();
            if(empty($receipt_already_verified->toArray())){
                $payment_verified = $this->stripeService->verifyPayment($request->attendee_receipt_number);
                // dd($payment_verified);
    
                if($payment_verified->original['status'] == 'success'){
                    // dd($request->all());
                    $attendance = EventRegistrationAttendance::create([
                        'attendee_first_name' => $request->attendee_first_name,
                        'attendee_last_name' => $request->attendee_last_name,
                        'attendee_email' => $request->attendee_email,
                        'attendee_phone_number' => $request->attendee_phone_number,
                        'event_registration_id' => $request->event_registration_id,
                        'attendee_company_name' => $request->attendee_company_name ?? null,
                        'attendee_company_description' => $request->attendee_company_description ?? null,
                        'attendee_company_url' => $request->attendee_company_url ?? null,
                        'attendee_number_of_employees_attending' => $request->attendee_number_of_employees_attending ?? null,
                        'acknowledgement_of_no_refunds' => $request->acknowledgement_of_no_refunds,
                        'attendee_receipt_number' => $request->attendee_receipt_number,
                        'attendee_charge' => $request->attendee_charge,        
                    ]);
    
                    $userNumber = $this->alertService->formatPhoneNumber($request['attendee_phone_number']);
                    $userName = $request->attendee_first_name. ' '.$request->attendee_last_name;
               
                    //add number to user 
                    $attendance->attendee_phone_number = $userNumber;
                    //save 
                    $attendance->save();
        
                    //send alert
                    // $this->alertService->sendAdminAlert($userName, $userNumber, 'Thank You For Your Purchase');
    
                    //send email
                    $alertInfo = $this->alertService->createBody($request, 'event_receipt');
                    $this->alertService->processAlert($alertInfo, $request['attendee_email']);
                    return response()
                        ->json([
                            'status' => 'success',
                            'message' => 'Guest is Added!',
                        ], 
                        200
                    );
                } else {
                    return response()
                        ->json([
                            'status' => 'failure',
                            'message' => $payment_verified->original['message'],
                        ], 
                        400
                    );
                }

            } else {
                return response()
                    ->json([
                        'status' => 'error',
                        'message' => 'This receipt number has already been verified',
                    ], 
                    400
                );
            }
       
    }
    public function submitReservation(Request $request){
        //
    //     return response()
    //     ->json([
    //         'status' => 'success',
    //         'message' => $request->all(),
    //     ], 
    //     200
    // );
        $reservation = new Reservation;
        if(!empty($request->book_id)){
             $reservation->book_id = intval($request->book_id) ?? '';
        }
        if(!empty($request->issue_id)) {
            $reservation->issue_id = intval($request->issue_id) ?? '';
        }

        $reservation->price = $request->price;
        // $reservation->user_id = $request->user_id;
        $reservation->email = $request->email;
        $reservation->reservation_number = $request->reservation_number;
        $reservation->save();
        $book;
        $issue;

        if(isset($request->book_id) && !empty($request->book_id)){

            $book = Book::find($reservation->book_id);
            $alertInfo = $this->alertService->createBody($book, 'reservation');
            $this->alertService->processAlert($alertInfo, $request['email']);

        } else if(isset($request->issue_id) && !empty($request->issue_id)) {

            $issue = Issue::find($reservation->issue_id);
            $alertInfo = $this->alertService->createBody($issue, 'reservation');
           
            //IMPORTANT: this method will fail when testing IN sandbox
                // TO DO: VERIFY TASKS WITH MAILGUN TO SEND EMAILS OUT 
            $this->alertService->processAlert($alertInfo, $request['email']);

        } else {
            return response()
                    ->json([
                        'status' => 'error',
                        'message' => 'There was an unexpected error',
                    ], 
                    400
                );
        }

        return response()
        ->json([
            'status' => 'success',
            'message' => 'Reservation Set',
        ], 
        200
    );
    }

    public function getBlazeTokenTiers(Request $request){
        
        $tier = null;
        $tiers = null;
// dd($request->all());
        if(isset($request->token_tier_id)){

            $tier = BlazeTokenTier::find($request->token_tier_id);
        } else {
            $tiers = BlazeTokenTier::whereNull('deleted_at')->get();
        }

        $data = $request->all();
 
         if($tier && $tier->toArray()) {
             return response()
                 ->json([
                     'status' => 'success',
                     'data' => $tier,
                 ], 
                 200
             );
         } else if($tiers && $tiers->toArray()) {
            return response()
                 ->json([
                     'status' => 'success',
                     'data' => $tiers,
                 ], 
                 200
             );
         } else {
             return response()
                 ->json([
                     'status' => 'error',
                     'message' => 'Could Not Find Any Tiers',
                     'data' => $data,
                 ], 
                 400
             );
         }
 
     }

}
