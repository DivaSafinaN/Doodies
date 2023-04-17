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
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TaskGroup $taskGroup)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required',
            'notes' => 'nullable',
            'file' => 'nullable',
            'due_date' => 'nullable|date',
            'reminder' => 'nullable|date',
        ]);
    
        $taskGroup->tasks()->create($validatedData);
    
        return redirect()->route('task_groups.edit', [$taskGroup->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskGroup $taskGroup,Task $task)
    {
        $priority = Priority::all();
        return view('tasks.edit', compact('taskGroup', 'task', 'priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, TaskGroup $taskGroup,Task $task)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path().'/file',$fileName);
            $data['file'] = $fileName;
        }

        $task->update($data);
        // dd($task);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskGroup $taskGroup, Task $task)
    {
        $task->delete(); 
        return redirect()->back();

    }

}
