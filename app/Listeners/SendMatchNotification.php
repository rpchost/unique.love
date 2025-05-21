<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Mail\MatchNotificationEmail;
use Illuminate\Support\Facades\Mail;

class SendMatchNotification
{
    public function handle(MatchCreated $event)
    {
        $match = $event->match;
        $user = $match->user; // Assuming user() relation on Match model
        Mail::to($user->email)->send(new MatchNotificationEmail($match));
    }
}
