<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trash:deleteTasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Tasks from trash permanently';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::onlyTrashed()
        ->where('deleted_at', '<=', now()->subDays(3))
        ->get();

        foreach ($tasks as $task) {
            $task->forceDelete();
        }

        Log::info('Task cleanup finished.');
    }
}
