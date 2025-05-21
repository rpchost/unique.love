<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MatchSuggestion extends Notification
{
    use Queueable;

    protected $suggestedUser;

    public function __construct(User $suggestedUser)
    {
        $this->suggestedUser = $suggestedUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('New Match Suggestion!')
            ->line('Meet ' . $this->suggestedUser->name . '!')
            ->action('View Profile', url('/users/' . $this->suggestedUser->id))
            ->line('Happy matching!');
    }
}
