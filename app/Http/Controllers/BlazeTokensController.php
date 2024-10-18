<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlazeTokenTier;

class BlazeTokensController extends Controller
{
    //

    public function index(Request $request){
    
        $tiers  = BlazeTokenTier::whereNULL('deleted_at')->get();
      
        // dd($tiers->toArray());
        // return view('users.tokens.index', compact('tiers'));
        return view('tokens.index', compact('tiers'));
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

    public function edit(Request $request){
    
        $tier  = BlazeTokenTier::find($request->tier_id);
    //   dd($tier->toArray());

        return view('tokens.edit', compact('tier'));
    }

    public function submit(Request $request){
       

        $tier = BlazeTokenTier::create([
            'token_tier_name' => $request->token_tier_name,
            'token_tier_description' => $request->token_tier_description,
            'token_tier_amount' => $request->token_tier_amount,
            'token_tier_usd_price' => $request->token_tier_usd_price,
            'token_tier_is_active' => 1,
        ]);

        return redirect()->route('tokens.tiers.index');
    }

    public function update(Request $request){
       

        $tier = BlazeTokenTier::find($request->token_tier_id);

            $tier->token_tier_name = $request->token_tier_name;
            $tier->token_tier_description = $request->token_tier_description;
            $tier->token_tier_amount = $request->token_tier_amount;
            $tier->token_tier_usd_price = $request->token_tier_usd_price ?? $tier->token_tier_usd_price;
            $tier->token_tier_is_active = 1;

        $tier->save();
        
        return redirect()->route('tokens.tiers.index');
    }

           /**
     * Show the form for publishing the specified resource.
     */
    public function publish(Request $request, string $id)
    {
        //
        $tier = BlazeTokenTier::find($id);
        if($request->action == 'publish'){
            $tier->is_active = 1;
            $tier->save();
        } else {
            $tier->is_active = 0;
            $tier->save();
        }
       
        return redirect()->route('tokens.tiers.index');
    }
    
    public function destroy(Request $request){
        $tier = BlazeTokenTier::find($request->tier_id);
        $tier->deleted_at = now();
        $tier->save();
        return redirect()->route('tokens.tiers.index');
    }
}
