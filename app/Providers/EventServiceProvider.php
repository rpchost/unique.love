protected $listen = [
    \App\Events\MatchCreated::class => [
        \App\Listeners\SendMatchNotification::class,
        \App\Listeners\UpdateUserStats::class,
        \App\Listeners\LogMatchActivity::class,
    ],
];