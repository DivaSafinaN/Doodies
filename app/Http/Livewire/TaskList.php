<?php

namespace App\Http\Livewire;

use App\Models\MyDay;
use App\Models\Task;
use App\Models\TaskGroup;
use Livewire\Component;

class TaskList extends Component
{
    public $taskGroup;
    public $myDay;

    public function mount(TaskGroup $taskGroup)
    {
        $this->taskGroup = $taskGroup;
        $this->myDay = MyDay::where('task_group_id', $taskGroup->id)->get();
    }

    public function render()
    {
        
        return view('livewire.task-list');
    }

    
}
