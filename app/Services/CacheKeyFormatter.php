<?php

declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class CacheKeyFormatter
{
    public function format(string $key, array $params): string
    {
        $replacements = [];
        foreach ($params as $param => $value) {
            $replacements['{' . $param . '}'] = (string) $value;
        }

        $formattedKey = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $key
        );

        // Validate PSR-6 key (A-Z, a-z, 0-9, _, .)
        if (!preg_match('/^[A-Za-z0-9_.]+$/', $formattedKey)) {
            Log::error('Invalid cache key generated', ['key' => $formattedKey]);
            throw new InvalidArgumentException("Invalid cache key: {$formattedKey}");
        }

        return $formattedKey;
    }
}
