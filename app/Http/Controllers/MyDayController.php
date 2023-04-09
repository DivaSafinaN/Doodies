<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\Priority;
use App\Models\TaskGroup;
use Illuminate\Http\Request;

class MyDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sort=null)
    {
        $user_id = auth()->user()->id;

        $myDay = MyDay::where('completed', false)
                      ->where('user_id', $user_id)
                      ->get();
        
        $taskGroups = TaskGroup::where('user_id', $user_id)
                               ->get();

        return view('my_day.index', compact('myDay','taskGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'notes' => 'nullable',
            'due_date' => 'nullable|date',
            'reminder' =>'nullable|date'
        ]);
    
        $validatedData['user_id'] = auth()->user()->id;
        MyDay::create($validatedData);
    
        return redirect()->route('my_day.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyDay $myday
     * @return \Illuminate\Http\Response
     */
    public function edit(MyDay $myDay)
    {
        $priority = Priority::all();
        return view('my_day.edit', compact('myDay', 'priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyDay $myDay)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'notes' => 'nullable',
            'due_date' => 'nullable|date',
            'priority_id' => 'required',
            'reminder' => 'nullable|date'
        ]);
        
        $myDay->update($validatedData);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyDay $myDay)
    {
        $myDay->delete();

        return redirect()->back();
    }
}
