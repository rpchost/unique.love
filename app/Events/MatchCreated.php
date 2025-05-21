<?php

namespace App\Events;

use App\Models\UserMatch;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $match;

    public function __construct(UserMatch $match)
    {
        $this->match = $match;
    }
}
