<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Renewable;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



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


        $expiredDocuments = Renewable::whereDate('Expired_date', '<', Carbon::today())->get();

        $notifications = Notification::latest()->take(10)->get();


        
    $data = Renewable::selectRaw('MONTH(renewable_date) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $monthlyUsers = User::select(
           DB::raw('MONTH(created_at) as month_number'),
                  DB::raw('COUNT(*) as count')
         ) ->groupBy('month_number')->orderBy('month_number')->pluck('count', 'month_number'); 
        $months = [
               1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 
              5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 
              9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
             ];
      $labels = array_values($months);
      $data = [];
      foreach ($months as $num => $name) {
           $data[] = $monthlyUsers[$num] ?? 0; 
      }


    $recentUsers = User::latest()->take(5)->get();
        return view('livewire.admin.pages.home', [
            'totalUsers' => $totalUsers,
            'totalVehicles' => $totalVehicles,
            'vehiclesByType' => $vehiclesByType,
            'upcomingRenewals' => $upcomingRenewals,
            'expiredDocuments' => $expiredDocuments,
            'notifications' => $notifications,
            'labels' => $labels,
            'data' => $data,
               'recentUsers' => $recentUsers,
        ])->layout('layouts.admin.admin');
    }
}
