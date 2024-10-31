<?php
namespace App\Services;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Stripe\Exception\RateLimitException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;

class StripeService
{

    // need to hide this in include creds;

    public function __construct() { 
    
        $this->secret_key = env('TEST_STRIPE_SECRET');

    }

    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('TEST_STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount, // Amount in cents
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
    function createCardToken($number,$exp_month,$exp_year,$cvc){

        $stripe = new \Stripe\StripeClient($this->secret_key);
        try {
           $tokens = $stripe->tokens->create([
                    'card' => [
                    'number' => $number,
                    'exp_month' => $exp_month,
                    'exp_year' => $exp_year,
                    'cvc' => $cvc,
                ],
            ]);
           
            // dd('yos');
        } catch(\Stripe\Exception\CardException $e)  {
            return false;
        }
        // $tokens = $stripe->tokens->create([
        //         'card' => [
        //         'number' => $number,
        //         'exp_month' => $exp_month,
        //         'exp_year' => $exp_year,
        //         'cvc' => $cvc,
        //     ],
        // ]);
        // dd($tokens->toArray());
        return $tokens->id;
       

    }


    function createCharge($token,$amount,$description = null){  

        $stripe = new \Stripe\StripeClient($this->secret_key);
        $charge = $stripe->charge->create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => $description,
            'source' => $token,
        ]);

        return $charge;

    }


    //customer and paymethods are for recurring charges

    function createCustomer($name, $email, $description = null){
        
        $stripe = new \Stripe\StripeClient($this->secret_key);
        $customer = $stripe->customers->create([
            'description' => $description,
            'name' => $name
        ]);
        // dd($customer->toArray());
        return $customer;
    }

    function createCardPayMethod($number,$exp_month,$exp_year,$cvc){
        $stripe = new \Stripe\StripeClient($this->secret_key);
        $method = $stripe->paymentMethods->create([
        'type' => 'card',
        'card' => [
            'number' => $number,
            'exp_month' => $exp_month,
            'exp_year' => $exp_year,
            'cvc' => $cvc,
        ],
        ]);
        // dd($method->toArray());
        return $method;

    }

    function charge($intent_id){

        $stripe = new \Stripe\StripeClient($this->secret_key);
        try {
            $confirm = $stripe->paymentIntents->confirm($intent_id);
        } catch(\Stripe\Exception\CardException $e) {
            return false;
        }
       
        // dd($confirm->toArray());
        return $confirm;
        
    }

    function refundPayment($charge,$amount){
        $refund = $stripe->refunds->create([
            'charge' => $charge,
            'amount'=> $amount,
        ]);

            return $refund;
    }
    public function verifyPayment($paymentIntentId)
    {
        
        try {
            // Set the Stripe API key
            Stripe::setApiKey($this->secret_key);

            // Retrieve the PaymentIntent by ID
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // Check the payment status
            if ($paymentIntent->status == 'succeeded') {
                // Payment succeeded, handle your logic here
               
                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment was successful.',
                    'payment_intent' => $paymentIntent,
                ]);
            } else {
                // Payment not successful
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Payment failed or is still processing.',
                    'payment_intent' => $paymentIntent,
                ]);
            }
        } catch (ApiErrorException $e) {
            // Handle generic API errors
            
            return ['error' => $e->getMessage()];
        }
    }
    public function confirmPaymentIntent($intent_id, $method_id)
    {
        // Set your Stripe API key
        Stripe::setApiKey($this->secret_key);

        // Confirm the PaymentIntent with payment method
        try {
            $paymentIntent = PaymentIntent::retrieve($intent_id);

            $paymentIntent->confirm([
                'payment_method' => $method_id,
            ]);

            return response()->json([
                'success' => true,
                'paymentIntent' => $paymentIntent,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

