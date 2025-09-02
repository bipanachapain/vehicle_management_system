<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Renewable;
use App\Models\Notification;
use Carbon\Carbon;

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
    protected $description = 'Create notifications for renewables that are expired or expiring in the next 3 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $end = Carbon::today()->addDays(3);

        // Fetch renewables that are already expired or will expire within 3 days
        $renewables = Renewable::with(['vehicle.user', 'documentType'])
            ->whereDate('expired_date', '<=', $end->toDateString())
            ->get();

        foreach ($renewables as $renewable) {
            // Only take the latest record for each vehicle + document type
            $latest = Renewable::where('vehicle_id', $renewable->vehicle_id)
                ->where('document_type_id', $renewable->document_type_id)
                ->orderByDesc('renewable_date')
                ->orderByDesc('id')
                ->first();

            if ($latest && $latest->id !== $renewable->id) {
                continue;
            }

            $daysLeft = $today->diffInDays(Carbon::parse($renewable->expired_date), false);

            if ($daysLeft > 3) {
                continue; // too far in the future
            }

            $vehicleLabel = $renewable->vehicle->vehicle_number
                ?? ('Vehicle#' . $renewable->vehicle_id);

            $documentLabel = $renewable->documentType->name ?? 'Document';

            // Message template
            if ($daysLeft < 0) {
                $text = strtr(':document for :vehicle already expired :days day(s) ago (on :expired_date).', [
                    ':vehicle' => $vehicleLabel,
                    ':document' => $documentLabel,
                    ':days' => abs($daysLeft),
                    ':expired_date' => Carbon::parse($renewable->expired_date)->format('Y-m-d'),
                ]);
            } elseif ($daysLeft === 0) {
                $text = strtr(':document for :vehicle expires today (:expired_date).', [
                    ':vehicle' => $vehicleLabel,
                    ':document' => $documentLabel,
                    ':expired_date' => Carbon::parse($renewable->expired_date)->format('Y-m-d'),
                ]);
            } else {
                $text = strtr(':document for :vehicle expires in :days_left day(s) on :expired_date.', [
                    ':vehicle' => $vehicleLabel,
                    ':document' => $documentLabel,
                    ':days_left' => (string) $daysLeft,
                    ':expired_date' => Carbon::parse($renewable->expired_date)->format('Y-m-d'),
                ]);
            }

            // Avoid duplicate notifications for the same renewable on the same day
            $already = Notification::where('renewable_id', $renewable->id)
                ->whereDate('created_at', $today->toDateString())
                ->where('message', $text)
                ->exists();

            if ($already) {
                continue;
            }

            // Collect contact info
            $userPhone = $renewable->vehicle->user->phone ?? null;
            $userEmail = $renewable->vehicle->user->email ?? null;

            // Dispatch notification job (make sure your Job sends email/SMS properly)
            if ($userPhone || $userEmail) {
                \App\Jobs\SendUserNotification::dispatch($userPhone, $userEmail, $text);
            }

            // Save notification in DB
            Notification::create([
                'renewable_id' => $renewable->id,
                'message' => $text,
            ]);
        }

        $this->info('Notifications created successfully.');
        return self::SUCCESS;
    }
}
