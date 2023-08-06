<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){

        $tax = config('cart.tax')/100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::subtotal()-$discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return view('cart')->with([
            'discount'=>$discount,
            'newSubtotal'=>$newSubtotal,
            'newTax'=>$newTax,
            'newTotal'=>$newTotal
        ]);
    }


    public function store(Request $request){
        $product = Product::findOrFail($request->input('id'));

        $duplicates = Cart::search(function ($cartItem,$rowId) use ($product){
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('message','Item is already in your cart!');
        }

        Cart::add(
            $product->id,
            $product->name,
            1,
            $product->original_price
        )->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('message','Item is added to your cart');
    }


    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors',collect(['Quantity must be between 1 and 5']));
            return response()->json(['success'=>false],400);
        }
        Cart::update($id,$request->quantity);
        session()->flash('message','Quantity was updated successfully!');
        return response()->json(['success'=>true]);
    }


    public  function destroy($id){
        Cart::remove($id);
        return back()->with('message', 'Item has been removed from your cart!');

    }


}
