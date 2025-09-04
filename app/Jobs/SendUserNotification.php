<?php

namespace App\Jobs;

use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\RenewableNotificationMail;
use Illuminate\Support\Facades\Http;

class SendUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;
   protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct($phone,$email, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $service): void
    {

            
        // Send SMS
       if ($this->email) {
            Mail::to($this->email)->send(new RenewableNotificationMail($this->message));
        if (count(Mail::failures()) > 0) {
        \Log::error('Mail failed to send: ' . implode(', ', Mail::failures()));
    }
        }
        
    //   if ($this->phone) {
    //             $service->sendSMS($this->phone, $this->message);
    //              $service->sendWhatsApp($this->phone, $this->message);
    //        }


      if ($this->phone) {
        $response = $this->sendWhatsAppText($this->phone, $this->message);

        if (isset($response['error'])) {
            \Log::warning("WhatsApp free-form failed: " . json_encode($response['error']));

            // Optionally, fallback to template message
            // $this->sendWhatsAppTemplate($this->phone, $this->message);
        }
    }

    }
    private function sendWhatsAppText($phone, $message): array
    {
        $to  = $this->formatPhone($phone);
        $url = "https://graph.facebook.com/" . env('WHATSAPP_VERSION') . "/" . env('WHATSAPP_PHONE_ID') . "/messages";

        $response = Http::withToken(env('WHATSAPP_TOKEN'))->post($url, [
            "messaging_product" => "whatsapp",
            "to"                => $to,
            "type"              => "text",
            "text"              => ["body" => $message],
        ]);

        if ($response->failed()) {
            \Log::error("WhatsApp free-form send failed: " . $response->body());
        } else {
            \Log::info("WhatsApp free-form sent to {$to}");
        }

        return $response->json();
    }
    private function formatPhone(string $phone): string
{
    // Remove anything that is not a number
    $to = preg_replace('/[^0-9]/', '', $phone);

    // Add Nepal country code if missing
    if (substr($to, 0, 2) !== '97') {
        $to = '977' . $to;
    }

    return $to;
}

}
