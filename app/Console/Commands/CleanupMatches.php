<?php

namespace App\Console\Commands;

use App\Models\UserMatch;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupMatches extends Command
{
    protected $signature = 'matches:cleanup';

    protected $description = 'Delete pending matches older than one week';

    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        $deleted = UserMatch::where('created_at', '<', $oneWeekAgo)
            ->delete();

        $this->info("Deleted $deleted expired matches.");
    }
}
