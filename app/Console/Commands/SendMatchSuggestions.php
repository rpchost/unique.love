<?php

namespace App\Console\Commands;

use App\Mail\MatchSuggestion;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMatchSuggestions extends Command
{
    protected $signature = 'matches:suggestions';

    protected $description = 'Send daily match suggestions to users';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Simple match logic: get up to 3 random users (excluding self)
            $matches = User::where('id', '!=', $user->id)
                ->inRandomOrder()
                ->limit(3)
                ->get();

            if ($matches->isNotEmpty()) {
                try {
                    Mail::to($user->email)->send(new MatchSuggestion($user, $matches));
                    $this->info("Match suggestion sent to {$user->email}");
                } catch (\Exception $e) {
                    $this->error("Failed to send to {$user->email}: {$e->getMessage()}");
                }
            }
        }

        $this->info('Match suggestions sent successfully.');
    }
}
