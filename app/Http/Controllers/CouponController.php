<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request){
        $coupon= Coupon::where('code',$request->coupon_code)->first();
        if (!$coupon){
            return redirect()->route('cart.index')->withErrors('Invalid coupon code. Please try again.');
        }

        session()->put('coupon',[
            'name'=>$coupon->code,
            'discount'=>$coupon->discount(Cart::subtotal())
        ]);
        return redirect()->route('cart.index')->with('message','Coupon has been applied!');
    }

    public function destroy(){
        session()->forget('coupon');
        return redirect()->route('cart.index')->with('message','Coupon has been removed!');
    }
}
