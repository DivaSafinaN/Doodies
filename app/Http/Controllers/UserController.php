<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit_profile(){
        return view('user.edit-profile');
    }

    public function update_profile(Request $request){
        $validatedData = $request->validate([
            'name' => ['string','min:3','required'],
            'email' => ['string','required']
        ]);

        Auth::user()->update($validatedData);

        return back()->with('message', 'Profile has been updated');
    }

    public function edit_password(){
        return view('user.edit-password');
    }

    public function update_password(Request $request){
        dd('success');
    }

}
