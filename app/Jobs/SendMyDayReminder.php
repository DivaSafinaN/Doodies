<?php

namespace App\Jobs;

use App\Models\MyDay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMyDayReminder implements ShouldQueue
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

        $tasks = MyDay::join('users', 'users.id', '=', 'my_days.user_id')
            ->whereNotNull('my_days.reminder')
            ->where('my_days.reminder', '<=', $now)
            ->where('my_days.completed', false)
            ->where('users.email', '!=', null)
            ->get(['my_days.*']);

        foreach ($tasks as $task) {
            $task->sendReminderEmail();
            // Log::info("Reminder sent for task #{$task->id}");
            $task->update(['reminder' => NULL]);
        }
    }
}
