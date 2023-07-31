<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(){
        return view('checkout');
    }


    public function store(Request $request){
        $attributes = $request->validate([
            'user_id'=> $request->user()->id,
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|numeric|digits:11',
            'address_line1'=>'required',
            'country'=>'required|string',
            'city'=>'required|string',
            'state'=>'required|string',
            'zip_code'=>'required|regex:/\b\d{5}\b/',
            'payment_method'=>'required',
        ]);

        Checkout::create($attributes);
        return back();
    }
}
