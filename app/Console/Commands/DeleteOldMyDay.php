<?php

namespace App\Console\Commands;

use App\Models\MyDay;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldMyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trash:deleteMyDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete My Day from trash permanently';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $myDays = MyDay::onlyTrashed()
        ->whereNotNull('deleted_at')
        ->where('deleted_at', '<=', now()->subDays(3))
        ->get();

        foreach ($myDays as $myDay) {
            $myDay->forceDelete();
        }

        Log::info('Task cleanup finished.');
    }
}
