<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Renewable;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Carbon\Carbon;


class AdminDashboard extends Component
{
    public function render()
    {
        $totalUsers = User::count();
        $totalVehicles = Vehicle::count();
        $vehiclesByType = Vehicle::with('vehicleType')->get()->groupBy('vehicleType.name');
        
        $upcomingRenewals = Renewable::whereDate('Expired_date', '>=', Carbon::today())
            ->whereDate('Expired_date', '<=', Carbon::today()->addDays(30))
            ->get();
        $renewalsTimelineData = Renewable::selectRaw('DATE(Expired_date) as date, COUNT(*) as count')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

        $timelineRaw = Vehicle::query()
            ->selectRaw("DATE_FORMAT(purchase_date, '%b %Y') as m, COUNT(*) as total, MIN(purchase_date) as ord")
            ->groupBy('m')
            ->orderBy('ord')
            ->pluck('total', 'm');   // e.g. ["Aug 2025" => 2, "Sep 2025" => 5]

        $renewalsTimeline = [
            'labels' => $timelineRaw->keys()->values()->all(),   // ["Aug 2025", "Sep 2025", ...]
            'counts' => $timelineRaw->values()->all(),           // [2, 5, ...]
        ];


// Format for chart.js

        $expiredDocuments = Renewable::whereDate('Expired_date', '<', Carbon::today())->get();

        $notifications = Notification::latest()->take(10)->get();

        return view('livewire.admin.pages.home', [
            'totalUsers' => $totalUsers,
            'totalVehicles' => $totalVehicles,
            'vehiclesByType' => $vehiclesByType,
            'upcomingRenewals' => $upcomingRenewals,
            'expiredDocuments' => $expiredDocuments,
            'notifications' => $notifications,
            'renewalsTimeline' => $renewalsTimeline,
        ])->layout('layouts.admin.admin');
    }
}
