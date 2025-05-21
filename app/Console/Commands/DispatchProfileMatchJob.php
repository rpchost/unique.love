<?php

namespace App\Console\Commands;

use App\Jobs\ProcessProfileMatch;
use App\Models\User;
use Illuminate\Console\Command;

class DispatchProfileMatchJob extends Command
{
    protected $signature = 'app:match-profiles {user_id? : The ID of the user to match}';

    protected $description = 'Dispatch a profile matching job for a user';

    public function handle()
    {
        if ($userId = $this->argument('user_id')) {
            // Match for a specific user
            $user = User::findOrFail($userId);
            $this->matchForUser($user);
        } else {
            // Match for all users
            $this->matchForAllUsers();
        }

        $this->info('Profile matching jobs have been dispatched to the queue.');
        $this->info('Run "php artisan queue:work" to process the jobs.');
    }

    private function matchForUser(User $user)
    {
        $this->info("Dispatching profile match job for user: {$user->name} (ID: {$user->id})");
        ProcessProfileMatch::dispatch($user);
    }

    private function matchForAllUsers()
    {
        $count = 0;
        User::chunk(10, function ($users) use (&$count) {
            foreach ($users as $user) {
                ProcessProfileMatch::dispatch($user);
                $count++;
            }
        });

        $this->info("Dispatched profile match jobs for {$count} users");
    }
}
