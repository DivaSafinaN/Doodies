<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use Illuminate\Http\Request;

class MyDayAdditionals extends Controller
{
    public function complete(MyDay $myDay){
        $myDay->update(['completed' =>true]);
        return redirect()->back();
    }

    public function incomplete(MyDay $myDay){
        $myDay->update(['completed'=>false]);
        return redirect()->back();
    }
}
