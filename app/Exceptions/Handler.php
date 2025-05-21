<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            file_put_contents(storage_path('logs/exception_debug.log'), 'Exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL, FILE_APPEND);
        });
    }

    public function report(Throwable $e)
    {
        file_put_contents(storage_path('logs/exception_debug.log'), 'Reported exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL, FILE_APPEND);
        parent::report($e);
    }
}
