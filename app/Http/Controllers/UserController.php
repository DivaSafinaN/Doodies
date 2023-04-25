<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationException;
use Laravolt\Avatar\Facade as Avatar;

class UserController extends Controller
{

    public function login(){
        return view('user.login');
    }
    public function enter(Request $request){
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $user = User::whereEmail($request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                // dd($user);
                Auth::login($user);
                
                if (auth()->user()->is_admin) {
                    return redirect('/manage-user');
                }else{
                    return redirect('/my_day');
                }
            };
        }

        throw ValidationException::withMessages([
            'password' => 'Your provide credentials does not match our records.'
        ]);
    }
    public function __invoke(){
        Auth::logout();
        return redirect('/');
    }
    public function register(){
        return view('user.register');
    }
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required','unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Avatar::create($request->name)->save(public_path().'/assets/image'.$user->id.'.png');

        Auth::login($user);

        return redirect('/my_day');
    }
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
        $validatedData = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        if(Hash::check($request->current_password, auth()->user()->password)){
           auth()->user()->update(['password' => Hash::make($request->password)]);
            return back()->with('message', 'Your password has been updated'); 
        }
        
        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match our record.'
        ]);
    }

}
