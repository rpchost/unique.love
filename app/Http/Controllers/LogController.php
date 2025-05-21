<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogController extends Controller
{
    public function index()
    {
        // Create a Monolog logger instance
        $log = new Logger('my_logger');
        $log->pushHandler(new StreamHandler(storage_path('logs/my_log.log'), Logger::INFO));
        // Log a message
        $log->info('Visited the /log route');
        // Return a response
        return response()->json(['message' => 'Log written to my_log.log']);
    }
}
