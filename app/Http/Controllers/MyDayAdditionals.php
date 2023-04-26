<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\TaskGroup;
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

    public function restore($id){
        $myDay = MyDay::withTrashed()->find($id);
        $myDay->restore();
        return redirect()->back();
    }

    public function delete($id){
        $myDay = MyDay::withTrashed()->find($id);
        $myDay->forceDelete();
        return redirect()->back();
    }

    public function filegone(MyDay $myDay){
        $filePath = public_path().'/mydayfile/'.$myDay->file;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    
        $myDay->update(['file' => null]);
    
        return redirect()->back();
    }

    public function addToTaskGroup(Request $request, MyDay $myDay){
        $request->validate([
            'task_group_id' => 'required|exists:task_groups,id',
        ]);
    
        $myDay->task_group_id = $request->task_group_id;

        $myDay->save();
        return redirect()->back();
    }

    public function delFrTaskGroup(MyDay $myDay){
        $myDay->task_group_id;
        $myDay->task_group_id = null;

        $myDay->save();
        return redirect()->back();

    }
}
