<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class UserNotification extends Component
{ 
        public function render()
    {
        $user = auth()->user();

    $notifications = Notification::whereHas('renewable.vehicle', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with(['renewable.documentType', 'renewable.vehicle'])
        ->latest()
        ->take(5)
        ->get();
        return view('livewire.user-notification',compact('notifications'))->layout('layouts.user.user');
    }
}
