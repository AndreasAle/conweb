<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a WhatsApp message via Fonnte. No-ops (just logs) when no token is
     * configured yet, so callers never have to special-case dev mode.
     */
    public function sendMessage(string $phone, string $message): bool
    {
        $token = config('services.fonnte.token');

        if (! $token) {
            Log::info("Fonnte dev-mode: would send WA to {$phone}: {$message}");

            return false;
        }

        $response = Http::withHeaders(['Authorization' => $token])
            ->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
            ]);

        return $response->successful();
    }
}
