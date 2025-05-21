<?php

namespace App\Mail;

use App\Models\UserMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchNotificationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $match;

    public function __construct(UserMatch $match)
    {
        $this->match = $match;
    }

    public function build()
    {
        return $this->subject('New Match!')
            ->view('emails.match-notification')
            ->with(['match' => $this->match]);
    }
}
