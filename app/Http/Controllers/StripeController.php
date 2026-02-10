<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{


public function charge(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $totalAmount = $request->input('total_amount'); // send from form

   $paymentIntent = PaymentIntent::create([
    'amount' => $totalAmount * 100, // cents
    'currency' => 'usd',
    'payment_method' => $request->stripe_payment_method_id,
    'confirmation_method' => 'manual',
    'confirm' => true,
    'receipt_email' => $request->email, // add this
]);


    return response()->json(['success' => true]);
}

}
