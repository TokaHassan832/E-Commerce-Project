<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->paginate(6);
        return view('products.index',['products'=>$products]);
    }

    public function show(Product $product){
        $relatedProducts = $product->relatedProducts()->limit(4)->get();
        return view('products.show',['product'=>$product,'relatedProducts'=>$relatedProducts]);
    }
}
