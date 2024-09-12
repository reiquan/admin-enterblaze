<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Universe;
use App\Models\Issue;
use App\Services\BookService;
use App\Models\IssuePage;
use App\Models\Book;
use App\Models\EventRegistration;
use App\Models\EventRegistrationAttendance;

class ApiController extends Controller
{
 
    
    public function __construct(ValidationService $validationService){
        $this->validationService = $validationService;
        $this->stripeService = $stripeService;
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

    public function getOpenRegistrations(Request $request){
        
       $registrations = EventRegistration::where('registration_is_active', 1)
       ->where('registration_event_id', $request->registration_event_id)
       ->get();
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

        $validation = $this->validationService()->validateInput($request);

        if(!$validation){
            $payment_verified = $this->stripeService->verifyPayment($request->attendee_receipt_number);
            if($payment_verified['status'] == 'success'){
                $attendance = EventRegistrationAttendance::create[
                    $request->all()
                ];
            }
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
                    'status' => 'error',
                    'message' => 'Invalid Data',
                ], 
                400
            );
        }
       
            //once validated 
            //if receipt number is verified 
            //add them as an attendee to given event
    }

}
