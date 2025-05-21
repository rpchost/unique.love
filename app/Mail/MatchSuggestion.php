<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchSuggestion extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $matches;

    public function __construct(User $user, $matches)
    {
        $this->user = $user;
        $this->matches = $matches;
    }

    public function build()
    {
        return $this->subject('Your Daily Match Suggestions')
            ->view('emails.match-suggestion')
            ->with([
                'user' => $this->user,
                'matches' => $this->matches
            ]);
    }
}
