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

    public function store_inTG(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'notes' => 'nullable',
            'due_date' => 'nullable|date',
            'reminder' => 'nullable|date',
            'task_group_id' => 'required|exists:task_groups,id', // validate task_group_id exists
            'add_to_myday' => 'nullable|boolean',
        ]);
    
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['add_to_myday'] = false;
    
        $task = new Task($validatedData);
        $task->task_group_id = $validatedData['task_group_id'];
        // dd($task);
        $task->save();
    
        return redirect()->back();
    
    }

    public function comtask(){
        $user_id = auth()->user()->id;

        $tasks = Task::where('completed', true)
                    ->where('user_id', $user_id)
                    ->get();

        return view('additionals.completed', compact('tasks'));
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

        $tasks = Task::onlyTrashed()
                    ->where('user_id', $user_id)
                    ->get();

        return view('additionals.trash', compact('tasks'));
    }

    public function addToTaskGroup(Request $request, Task $task){
        $request->validate([
            'task_group_id' => 'required|exists:task_groups,id',
        ]);
    
        $task->task_group_id = $request->task_group_id;

        $task->save();
        return redirect()->back();
    }

    public function delFrTaskGroup(Task $task){
        $task->task_group_id;
        $task->task_group_id = null;

        $task->save();
        return redirect()->back();

    }
    public function restore(Task $tasks, $id){
        $task = $tasks->withTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->back();
    }

    public function delete(Task $tasks, $id){
        $task = $tasks->withTrashed()->findOrFail($id);
        $task->forceDelete();
        return redirect()->back();
    }

    public function fileTgone(TaskGroup $taskGroup, Task $task)
    {
        $filePath = storage_path('app/public/file/' . $task->file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $task->update(['file' => null]);

        return redirect()->back();
    }
}
