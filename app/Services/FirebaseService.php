<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log; // Menambahkan import untuk Log

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(base_path('firebase-credentials.json'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error('Firebase notification error: ' . $e->getMessage()); // Menggunakan Log yang diimport
            return false;
        }
    }

    public function sendMulticast($tokens, $title, $body, $data = [])
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        try {
            $this->messaging->sendMulticast($message, $tokens);
            return true;
        } catch (\Exception $e) {
            Log::error('Firebase multicast error: ' . $e->getMessage()); // Menggunakan Log yang diimport
            return false;
        }
    }
}
