<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $recentProducts=Product::latest()->take(8)->get();
        $offers=Offer::all();
        return view('index',['recentProducts'=>$recentProducts,'offers'=>$offers]);
    }
}
