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
        
        $renewables = Renewable::with(['vehicle.user', 'documentType'])
            ->whereDate('expired_date', '<=', $end->toDateString())
            ->get()
            ->groupBy(function ($item) {
               
                return $item->vehicle_id . '-' . $item->document_type_id;
            })
            ->map(function ($group) {
                
                return $group->sortByDesc('renewable_date')->sortByDesc('id')->first();
            });
        foreach ($renewables as $renewable) {
            $daysLeft = $today->diffInDays(Carbon::parse($renewable->expired_date), false);
            if ($daysLeft > 3) {
                continue; 
            }
            $vehicleLabel   = $renewable->vehicle->vehicle_number ?? ('Vehicle#' . $renewable->vehicle_id);
            $documentLabel  = $renewable->documentType->name ?? 'Document';
            $expiredDateStr = Carbon::parse($renewable->expired_date)->format('Y-m-d');

            if ($daysLeft < 0) {
                $text = "$documentLabel for $vehicleLabel already expired " . abs($daysLeft) . " day(s) ago (on $expiredDateStr).";
            } elseif ($daysLeft === 0) {
                $text = "$documentLabel for $vehicleLabel expires today ($expiredDateStr).";
            } else {
                $text = "$documentLabel for $vehicleLabel expires in $daysLeft day(s) on $expiredDateStr.";
            }
            
            $already = Notification::where('renewable_id', $renewable->id)
                ->whereDate('created_at', $today->toDateString())
                ->where('message', $text)
                ->exists();
            if ($already) {
                continue;
            }
            
            Notification::create([
                'renewable_id' => $renewable->id,
                'message'      => $text,
            ]);
        
            $userPhone = $renewable->vehicle->user->phone ?? null;
            $userEmail = $renewable->vehicle->user->email ?? null;
            
            if ($userPhone || $userEmail) {
                \App\Jobs\SendUserNotification::dispatch($userPhone, $userEmail, $text);
            }

           if ($userEmail) {
                $user = \App\Models\User::where('email', $userEmail)->first();

            if ($user) {
                  $user->notify(new \App\Notifications\RenewalNotification($text));
             }
        }

        }
        $this->info('Notifications created successfully.');
        return self::SUCCESS;
    }
}