<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        file_put_contents(storage_path('logs/route_debug.log'), 'RouteServiceProvider registered: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
    }

    public function boot(): void
    {
        file_put_contents(storage_path('logs/route_debug.log'), 'TAATATAWQ: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        try {
            // Directly load routes without $this->routes()
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            file_put_contents(storage_path('logs/route_debug.log'), 'Routes loaded directly: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        } catch (\Throwable $e) {
            file_put_contents(storage_path('logs/route_debug.log'), 'Direct routes error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL, FILE_APPEND);
        }
    }
}
