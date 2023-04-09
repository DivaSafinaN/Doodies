<?php

namespace App\Console\Commands;

use App\Mail\TaskReminder;
use App\Models\Task;
use Illuminate\Console\Command;

class SendTaskRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task reminder emails to users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
    }
}
