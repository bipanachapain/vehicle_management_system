<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Renewable;
use App\Models\Message;       
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RenewableNotificationMail;
class SendRenewableNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewables:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create notifications from message templates for renewables expiring in the next 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $end = Carbon::today()->addDays(3);
        $renewables = Renewable::with(['vehicle', 'documentType'])
            ->whereBetween('expired_date', [$today->toDateString(), $end->toDateString()])
            ->get();

        foreach ($renewables as $renewable) {


            $latest = Renewable::where('vehicle_id', $renewable->vehicle_id)
                ->where('document_type_id', $renewable->document_type_id)
                ->orderByDesc('renewable_date')
                ->orderByDesc('id')
                ->first();

            if ($latest && $latest->id !== $renewable->id) {

                continue;
            }


            $daysLeft = $today->diffInDays(Carbon::parse($renewable->expired_date), false);
            if ($daysLeft < 0 || $daysLeft > 3) {
                continue;
            }


            // $message_template = Message::where('document_type_id', $renewable->document_type_id)->value('message');
            // if (!$message_template) {

                $message_template = ':document for :vehicle expires in :days_left day(s) on :expired_date.';
            // }

            $vehicleLabel = $renewable->vehicle->vehicle_number
                ?? $renewable->vehicle->vehicle_number
                ?? ('Vehicle#' . $renewable->vehicle_id);

            $documentLabel = $renewable->documentType->name ?? 'Document';

            $text = strtr($message_template, [
                ':vehicle' => $vehicleLabel,
                ':document' => $documentLabel,
                ':days_left' => (string) $daysLeft,
                ':expired_date' => Carbon::parse($renewable->expired_date)->format('Y-m-d'),
            ]);



            $already = Notification::where('renewable_id', $renewable->id)
                ->whereDate('created_at', $today->toDateString())
                ->where('message', $text)
                ->exists();

            if ($already) {
                continue;
            }


            Notification::create([
                'renewable_id' => $renewable->id,
                'message' => $text,
            ]);
            $userPhone = $renewable->vehicle->user->phone ?? null; // adjust if relation is different
//              if ($userPhone) {
//              $service = app(\App\Services\NotificationService::class);
//                  $service->sendSMS($userPhone, $text);
//             $service->sendWhatsApp($userPhone, $text);
// }
            // Dispatch job to send SMS or WhatsApp notification
            if ($userPhone) {
                \App\Jobs\SendUserNotification::dispatch($userPhone, $text);
            }
            // Send email notification
            $userEmail = $renewable->vehicle->user->email;
            // $userEmail ="chapai.bipana65@gmail.com";
            // if ($userEmail) {
                Mail::to($userEmail)->send(new RenewableNotificationMail($text));
               
               // Mail::to($userEmail)->queue(new RenewableNotificationMail($text));
            // }
        }

        $this->info('Notifications created.');
        return self::SUCCESS;
    }
}
