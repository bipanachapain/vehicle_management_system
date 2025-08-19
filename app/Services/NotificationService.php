<?php

namespace App\Services;

use Twilio\Rest\Client;

class NotificationService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendSMS($to, $message)
    {
        return $this->twilio->messages->create($to, [
            'from' => config('services.twilio.phone'),
            'body' => $message,
        ]);
    }

    public function sendWhatsApp($to, $message)
    {
        return $this->twilio->messages->create("whatsapp:" . $to, [
            'from' => config('services.twilio.whatsapp'),
            'body' => $message,
        ]);
    }
}
