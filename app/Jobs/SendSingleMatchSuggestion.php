<?php

namespace App\Jobs;

use App\Mail\MatchSuggestion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSingleMatchSuggestion implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    public function handle()
    {
        $matches = User::where('id', '!=', $this->user->id)->inRandomOrder()->limit(3)->get();
        if ($matches->isNotEmpty()) {
            Mail::to($this->user->email)->send(new \App\Mail\MatchSuggestion($this->user, $matches));
        }
    }
}
