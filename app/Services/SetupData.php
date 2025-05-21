<?php

namespace App\Services;

class SetupData
{
    public static function setup(): void
    {
        // Pull Docker image (TestContainer)
        // e.g., exec('docker pull testcontainer:latest');
        echo "Setting up Docker TestContainer\n";
    }

    public static function cleanup(): void
    {
        // Clean Docker resources
        // e.g., exec('docker rm testcontainer');
        echo "Cleaning up Docker TestContainer\n";
    }
}
