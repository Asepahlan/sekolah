<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.key');
        $this->baseUrl = 'https://api.fonnte.com/send';
    }

    public function sendMessage($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl, [
                'target' => $phone,
                'message' => $message
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp notification error: ' . $e->getMessage());
            return false;
        }
    }
}
