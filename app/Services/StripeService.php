<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
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
            Stripe::setApiKey(env('STRIPE_SECRET'));

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
        } catch (Exception $e) {
            // Handle error
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

