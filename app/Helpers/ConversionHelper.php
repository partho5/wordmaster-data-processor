<?php

namespace App\Helpers;

class ConversionHelper
{
    public static function saveConversionLog(array $data): void
    {
        $logPath = storage_path('logs/capi_conversions.log');
        $timestamp = now()->toDateTimeString();

        $entry = "[$timestamp] "
            . "Event ID: " . ($data['event_id'] ?? 'null') . ", "
            . "Value: " . ($data['value'] ?? 'null') . ", "
            . "Currency: " . ($data['currency'] ?? 'null') . ", "
            . "Platform: " . ($data['platform'] ?? 'null') . ", "
            . "IP: " . ($data['ip'] ?? 'null') . ", "
            . "User Agent: " . ($data['user_agent'] ?? 'null') . ", "
            . "FBCLID: " . ($data['fbclid'] ?? 'null') . "\n";

        $existing = file_exists($logPath) ? file_get_contents($logPath) : '';
        file_put_contents($logPath, $entry . $existing);
    }
}
