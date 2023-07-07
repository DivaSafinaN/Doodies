<?php

namespace App\Http\Controllers;

use App\Models\MyDay;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        
        // $tasks = Task::with('taskGroup')
        // ->where('name', 'like', '%'.$q.'%')
        // ->where('completed', false)
        // ->whereHas('taskGroup', function ($q) {
        //     $q->where('user_id', Auth::id());
        // })
        // ->get();
        $tasks = Task::where('name', 'like', '%'.$q.'%')
        ->where('user_id', Auth::id())
        ->where('completed', false)
        ->get();

        return view('search-results', compact('tasks','q'));
    }
}
