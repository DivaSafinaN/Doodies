<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Priority;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $tasks = Task::where('completed', false)
                      ->where('user_id', $user_id)
                      ->where('add_to_myday', true)
                      ->get();
        
        $taskGroups = TaskGroup::where('user_id', $user_id)
                               ->get();

        return view('my_day.index', compact('tasks','taskGroups'));
    }    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TaskGroup $taskGroup)
    {
        $validatedData = $request->validate([
            'task_name' => 'required',
            'notes' => 'nullable',
            'due_date' => 'nullable|date',
            'reminder' =>'nullable|date'
        ]);
    
        $validatedData['user_id'] = auth()->user()->id;
        Task::create($validatedData);
    
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $priority = Priority::all();
        return view('tasks.edit', compact('task', 'priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
           $destination_path = 'public/file';
           $file = $request->file('file');
           $fileName = $file->getClientOriginalName();
           $path = $request->file('file')->storeAs($destination_path,$fileName);

           $data['file'] = $fileName;
        }

        $task->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete(); 
        return redirect()->back();

    }

}
