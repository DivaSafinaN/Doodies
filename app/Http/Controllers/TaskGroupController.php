<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroupRequest;
use App\Models\MyDay;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    public function create()
    {
        return view('task_groups.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskGroupRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();

    // Check if a task group with the same name already exists for the user
        if ($user->taskGroup()->where('name', $validatedData['name'])->exists()) {
            return redirect()->back()->withErrors(['TG_name' => 'A task group with that name already exists.']);
        }
        $validatedData['user_id'] = auth()->user()->id;

        TaskGroup::create($validatedData);
        return back()->with('message','New Task List has created.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskGroup  $taskGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskGroup $taskGroup, $sort=null)
    {
        $tGs = TaskGroup::where('user_id', auth()->user()->id)
        ->where('id', '<>', $taskGroup->id)
        ->orderBy($sort ?: 'name')
        ->get();
        return view('task_groups.edit', compact('tGs','taskGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskGroup  $taskGroup
     * @return \Illuminate\Http\Response
     */
    public function update(TaskGroupRequest $request, TaskGroup $taskGroup)
    {
        // $taskGroup->update($request->validated());
        // return redirect()->route('task_groups.edit',[
        //     $taskGroup->id
        // ]); 
        
        $existingTaskGroup = TaskGroup::where('name', $request->name)->where('id', '!=', $taskGroup->id)->first();
        if ($existingTaskGroup) {
            return redirect()->route('task_groups.edit', $taskGroup->id)->withErrors(['TG_name' => 'A task group with the same name already exists.']);
        }
    
        $taskGroup->update($request->validated());
    
        return redirect()->route('task_groups.edit', $taskGroup->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskGroup  $taskGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskGroup $taskGroup)
    {
        $taskGroup->forceDelete();
        return redirect('/tasks');
    }

}
