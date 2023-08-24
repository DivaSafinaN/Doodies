<?php

namespace App\Console\Commands;

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

class SendWhatsAppReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsappReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test reminder message to a WhatsApp number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        $taskController = new TaskController();

        $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
            ->whereNotNull('tasks.reminder')
            ->where('tasks.reminder', '<=', $now)
            ->where('tasks.completed', false)
            ->where('users.phone_number', '!=', null)
            ->get(['tasks.*']);

        foreach ($tasks as $task) {
            $taskController->sendReminderWhatsApp($task); 
            $task->update(['reminder' => NULL]);
        }
    }
}
