<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);
file_put_contents(storage_path('logs/kernel_debug.log'), 'Http Kernel Bound: App\Http\Kernel' . PHP_EOL, FILE_APPEND);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
file_put_contents(storage_path('logs/kernel_debug.log'), 'Console Kernel Bound: App\Console\Kernel' . PHP_EOL, FILE_APPEND);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
file_put_contents(storage_path('logs/kernel_debug.log'), 'Exception Handler Bound: App\Exceptions\Handler' . PHP_EOL, FILE_APPEND);

// Debug Application boot
$app->boot();
file_put_contents(storage_path('logs/app_debug.log'), 'Application booted: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);

return $app;
