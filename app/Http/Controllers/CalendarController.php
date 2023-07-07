<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\Task;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(){
        $events = array();
        $tasks = auth()->user()->tasks()->where('completed', false)->get();
        foreach($tasks as $t){
            $events[] = [
                'id' => $t->id,
                'title' => $t->name,
                'start' => $t->start_date,
                'end' => $t->end_date
            ];

        }
        // return $events;
        return view('additionals.calendar', ['events' => $events]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $tasks = new Task([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        $tasks->user_id = auth()->user()->id;
        $tasks->save();

        // return 'pass';
        return response()->json($tasks);
    }

    public function update(Request $request, $id){
        $tasks = Task::find($id);
        if(! $tasks){
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $tasks->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        // return $request;
        return response()->json("Event updated");
    }

    public function destroy($id){
        $tasks = Task::find($id);
        if(! $tasks){
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $tasks->delete();
        return $id;
    }
}
