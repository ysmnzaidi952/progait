<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $twilio;
    protected $from;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    public function sendMessage($to, $message)
    {
        return $this->twilio->messages->create(
            'whatsapp:' . $to,
            [
                'from' => $this->from,
                'body' => $message
            ]
        );
    }
}
