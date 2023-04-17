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
        $user_id = auth()->user()->id;

        $myDayTasks = MyDay::where('completed', true)
                    ->where('user_id', $user_id)
                    ->get();

        $taskGroups = TaskGroup::where('user_id', $user_id)
                            ->get();

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

    public function trash(){
        $user_id = auth()->user()->id;

        $myDayTasks = MyDay::onlyTrashed()
                    ->where('user_id', $user_id)
                    ->get();

        $taskGroups = TaskGroup::with(['tasks' => function ($query) {
            $query->withTrashed();
        }])->where('user_id', $user_id)->get();

        return view('additionals.trash', compact('myDayTasks','taskGroups'));
    }

    public function restore(TaskGroup $taskGroup, $id){
        $task = $taskGroup->tasks()->withTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->back();
    }

    public function delete(TaskGroup $taskGroup, $id){
        $task = $taskGroup->tasks()->withTrashed()->findOrFail($id);
        $task->forceDelete();
        return redirect()->back();
    }
}
