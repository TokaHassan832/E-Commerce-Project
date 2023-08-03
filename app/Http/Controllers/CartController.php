<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('cart',['products'=>$products]);
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


    public  function destroy($id){
        Cart::remove($id);
        return back()->with('message', 'Item has been removed from your cart!');

    }


}
