<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        return view('contact');
    }


    public function store(Request $request){
        $attributes = $request->validate([
            'name'=> 'required|string',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required'
        ]);

        Contact::create($attributes);
        return back();
    }
}
