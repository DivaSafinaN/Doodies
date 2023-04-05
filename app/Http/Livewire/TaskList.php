<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\TaskGroup;
use Livewire\Component;

class TaskList extends Component
{
    public $taskGroup;

    public function render()
    {
        return view('livewire.task-list');
    }

    
}
