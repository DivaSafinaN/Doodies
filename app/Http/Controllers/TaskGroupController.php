<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGroupRequest;
use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TaskGroup $taskGroup)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        TaskGroup::create($request->validated());
        return redirect('my_day');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskGroup  $taskGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskGroup $taskGroup, $sort=null)
    {
        return view('task_groups.edit', compact('taskGroup'));
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
        $taskGroup->update($request->validated());
        return redirect()->route('task_groups.edit',[
            $taskGroup->id
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskGroup  $taskGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskGroup $taskGroup)
    {
        $taskGroup->delete();
        return redirect('my_day');
    }

}
