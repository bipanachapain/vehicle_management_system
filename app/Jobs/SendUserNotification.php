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
        
      if ($this->phone) {
                $service->sendSMS($this->phone, $this->message);
                 $service->sendWhatsApp($this->phone, $this->message);
           }

    }
}
