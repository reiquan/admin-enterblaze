<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    //

    public function index(Request $request){
    
        $contests  = Event::where('event_type', 'Contest')->get();
        // dd($contests->toArray());
      
        // dd($tiers->toArray());
        // return view('users.tokens.index', compact('tiers'));
        return view('dashboard', compact('contests'));
    }

}
