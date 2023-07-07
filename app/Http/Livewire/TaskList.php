<?php

namespace App\Http\Livewire;

use App\Models\MyDay;
use App\Models\Task;
use App\Models\TaskGroup;
use Livewire\Component;

class TaskList extends Component
{
    public function updateTaskOrder($task){
        $order = collect($task)->map(function ($item, $index) {
            return [
                'order' => $index,
                'value' => $item['value'],
                'modelType' => $item['modelType'],
            ];
        })->all();
        dd($order);
        // foreach ($task as $item) {
        //     if ($item['class'] === 'App\Models\MyDay') {
        //         MyDay::find($item['value'])->update(['position' => $item['order']]);
        //     }elseif ($item['class'] === 'App\Models\Task') {
        //         Task::find($item['value'])->update(['position' => $item['order'], 'task_group_id' => $this->taskGroup->id]);
        //     }
        // }
    }
    public function render()
    {
        return view('livewire.task-list',[
            'myDay' => MyDay::orderBy('position')->get(),
            'taskGroups' => TaskGroup::all()
        ]);
    }
}
