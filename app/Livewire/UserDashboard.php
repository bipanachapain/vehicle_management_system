<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\Renewable;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\RenewableHistory;

class UserDashboard extends Component
{

    public function logout()
    {
        Auth::logout();              // Logs out the user
        session()->invalidate();      // Invalidate session
        session()->regenerateToken(); // Regenerate CSRF token
        return redirect()->route('login'); // Redirect to login page
    }
    public function render()
    {
        $userId = auth()->id();

        return view('user.pages.home', [
            'totalVehicles' => Vehicle::where('user_id', $userId)->count(),

            'upcomingRenewals' => Renewable::whereHas('vehicle', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->whereDate('expired_date', '<=', now()->addDays(30))
              ->orderBy('expired_date')
              ->get(),

            'notifications'=>Notification::whereHas('renewable.vehicle', function ($q) use ($userId) {
             $q->where('user_id', $userId);
               })
               ->orderBy('created_at', 'desc')
               ->limit(5)
                ->get(),

            'renewalHistory' => RenewableHistory::whereHas('vehicle', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->latest()->get(),
        ])->layout('layouts.user.user');
    }
}
