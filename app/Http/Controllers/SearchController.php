<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        
        $tasks = Task::with('taskGroup')->where('name', 'like', '%'.$q.'%')->get();
        $myDays = MyDay::where('name', 'like', '%'.$q.'%')->get();

        return view('search-results', compact('tasks', 'myDays'));
    }
}
