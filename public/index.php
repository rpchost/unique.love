<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Manually boot providers
$app->boot();
file_put_contents(storage_path('logs/app_debug.log'), 'Providers manually booted: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);

$kernel = $app->make(Kernel::class);
file_put_contents(storage_path('logs/kernel_debug.log'), 'Http Kernel Instantiated: ' . get_class($kernel) . PHP_EOL, FILE_APPEND);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);