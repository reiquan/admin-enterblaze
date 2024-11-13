<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscriber;
use App\Services\SubscriptionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Sanctum\CustomPersonalAccessToken;

class AuthApiController extends Controller
{
   //
   public function __construct(SubscriptionService $alertService){

        $this->alertService = $alertService;
    }
   public function loginSubscriber(Request $request)
   {
     
        $subscriber = Subscriber::where('email', $request->email)->first();
       
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $subscriber->remember_token = $subscriber->createToken('API Token')->plain_text_token;
        $subscriber->save();
        return response()->json(['token' =>  $subscriber->remember_token], 200);       
      
   }

    public function registerSubscriber(Request $request)
    {
        
        if(empty($request->name) || empty($request->email) || empty($request->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        if(isset($request->creator)) {
           
            $subscriber = Subscriber::where('name', $request->name)
                                    ->where('email', $request->email)
                                    ->first();
                    
           if($subscriber){
            
                $subscriber->is_creator = 1;
    
               
                $subscriber->save();
                
                $subscriber->portfolio_url = $request->creator['portfolio_url'];
              
                $alertInfo = $this->alertService->createBody($subscriber, 'artist_request');
               
                $this->alertService->processAlert($alertInfo, $request->email, 'new_artist');
            
                return response()->json(['success' => 'Artist request submitted!'], 200);

           } else {

                return response()->json(['error' => 'no subscriber found', 400]);

           }
        }

        $subscriber = Subscriber::where('email', $request->email)
                                    ->first();
        // dd($subscriber);
        if(!$subscriber){
            $subscriber_u_name= Subscriber::where('name', 'like',  '%'.$request->name.'%')
            ->get();
           $counter = 0;
           $name = '';
            if($subscriber_u_name) {
                // dd($subscriber_u_name->toArray());
                foreach($subscriber_u_name as $match){
                    preg_match_all('/\d+/', $match->name, $matches);
                    if(isset($matches) && $matches){
                        $m_number = isset($matches[0][0]) ?? '';
                        if($m_number == $counter){
                            $counter ++;
                        }
                    } else {
                        break;
                    }
                }
                $name = $name = $request->name.$counter;
            }
        

            $subscriber = new Subscriber;

            $subscriber->name = $name ? $name : $request->name;
            $subscriber->email = $request->email;
            $subscriber->password = Hash::make($request->password);
            $subscriber->save();
            $subscriber->remember_token = $subscriber->createToken('API Token')->plain_text_token;
            $subscriber->save();
    
            return response()->json(['token' => $subscriber->remember_token], 200);

        } else {

            return response()->json(['status' => 'email already taken'], 200);
        }
    }

    public function logoutSubscriber(Request $request)
    {
        
        $subscriber = Subscriber::where('remember_token', $request->header('bearer'))->first();
        $token = CustomPersonalAccessToken::where('token', $request->header('bearer'))->first();
        if($token) {
            $token->delete();
            $subscriber->remember_token = null;
            $subscriber->save();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    
}