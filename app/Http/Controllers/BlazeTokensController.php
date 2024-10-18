<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlazeTokenTier;

class BlazeTokensController extends Controller
{
    //

    public function index(Request $request){
    
        $tiers  = BlazeTokenTiers::all();
      
        dd($tiers->toArray());
        // return view('users.tokens.index', compact('tiers'));
        return view('tokens.index');
    }

    public function show(Request $request){
    
        // $tiers  = $this->apiService->getBlazeTokenTiers();
      
        // dd($request->all());
        // return view('users.tokens.index', compact('tiers'));
        return view('tokens.show');
    }
    public function create(Request $request){
    
        // $tiers  = $this->apiService->getBlazeTokenTiers();
      
        // dd($request->all());
        // return view('users.tokens.index', compact('tiers'));
        return view('tokens.create');
    }

    public function submit(Request $request){
       

        $tier = BlazeTokenTier::create([
            'token_tier_name' => $request->token_tier_name,
            'token_tier_description' => $request->token_tier_description,
            'token_tier_amount' => $request->token_tier_amount,
            'token_tier_usd_price' => $request->token_tier_usd_price,
            'token_tier_is_active' => 1,
        ]);

        return view('tokens.index');
    }
}
