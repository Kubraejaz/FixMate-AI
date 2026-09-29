<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class SmsService
{
    /**
     * Send an SMS via Twilio.
     *
     * When Twilio credentials are not configured the message is written to
     * the application log so local development is never blocked.
     */
    public function send(string $phone, string $message): bool
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        if ($sid && $token && $from) {
            try {
                $client = new Client($sid, $token);
                $client->messages->create($phone, ['from' => $from, 'body' => $message]);

                return true;
            } catch (\Throwable $e) {
                Log::error('Twilio SMS failed: '.$e->getMessage());
            }
        }

        Log::info('SMS (no gateway configured, logged instead): '.$message.' -> '.$phone);

        return false;
    }
}