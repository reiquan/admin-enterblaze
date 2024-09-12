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

    
    
}
