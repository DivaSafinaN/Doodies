<?php

namespace App\Jobs;

use App\Mail\TaskReminder;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTaskReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = now();

        $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
            ->whereNotNull('tasks.reminder')
            ->where('tasks.reminder', '<=', $now)
            ->where('tasks.completed', false)
            ->where('users.email', '!=', null)
            ->get(['tasks.*']);

        foreach ($tasks as $task) {
            $task->sendReminderEmail();
            // Log::info("Reminder sent for task #{$task->id}");
            $task->update(['reminder' => NULL]);
        }
    }
}
