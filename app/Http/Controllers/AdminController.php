<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        // $user = User::all();

        $user = User::select("*")
                    ->whereNotNull('last_seen')
                    ->where('is_admin',0)
                    ->orderBy('last_seen', 'DESC')
                    ->get();

        return view('admin.manage', compact('user'));
    }

    public function delete(User $user){
        $this->middleware('is_admin');
        
        $user->forceDelete();
        return redirect()->back();
    }
}
