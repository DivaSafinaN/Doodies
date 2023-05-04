<?php

namespace App\Http\Livewire;

use App\Models\MyDay;
use App\Models\Task;
use App\Models\TaskGroup;
use Livewire\Component;

class TaskList extends Component
{
    public $message = '';
    public $user_id = 42;

    public function render()
    {
        return view('livewire.task-list');
    }

    public function callFunction()
    {
        $this->message = "You clicked on button";
    }

    public function callFunctionArg($user_id)
    {
        $this->message = $user_id;
    }
}
