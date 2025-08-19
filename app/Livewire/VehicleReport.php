<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;

class VehicleReport extends Component
{
  public $user;
    public $vehicles;

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->vehicles = $this->user->vehicles()->with('vehicleType')->get();
    }

    public function render()
    {
        return view('livewire.vehicle-report')->layout('layouts.admin.admin');
    }
}
