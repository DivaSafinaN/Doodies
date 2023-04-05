<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskAdditionals extends Controller
{
    
    public function complete(TaskGroup $taskGroup,Task $task){
        $task->update(['completed' =>true]);
        return redirect()->back();
    }

    public function incomplete(TaskGroup $taskGroup, Task $task){
        $task->update(['completed'=>false]);
        return redirect()->back();
    }

    public function comtask(){
        $taskGroups = TaskGroup::all();
        $myDayTasks = MyDay::where('completed', true)->get();

        return view('additionals.completed', compact('myDayTasks','taskGroups'));
    }

    public function addtomyday(TaskGroup $taskGroup, Task $task){
        $task->update(['add_to_myday' => true]);
        return redirect()->back();
    }

    public function removefrmyday(TaskGroup $taskGroup, Task $task){
        $task->update(['add_to_myday' => false]);
        return redirect()->back();
    }
}
