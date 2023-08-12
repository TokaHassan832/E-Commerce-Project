<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Checkout;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function index(){
        return view('checkout');
    }


    public function store(CheckoutRequest $request){

        $contents = Cart::content()->map(function ($item) {
           return $item->model->name.','.$item->qty;
        })->values()->toJson();


        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $stripe->paymentIntents->create([
                'amount' => intval(Cart::total() * 100),
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'description' => 'Order',
                'confirm' => true,
                'receipt_email' => $request->email,
                'metadata'=>[
                    'contents'=>$contents,
                    'quantity'=>Cart::instance('default')->count(),
                ],

            ]);

            Cart::instance('default')->destroy();

            return redirect()->route('confirmation.index')->with('message','Thank You! Your payment has been successfully accepted!');

        }
        catch (CardException $e) {
            return back()->withErrors('Error! '. $e->getMessage());
        }


    }
}
