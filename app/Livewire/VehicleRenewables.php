<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;

class VehicleRenewables extends Component
{public $vehicle;
    public $renewables;

    public function mount($vehicleId)
    {
        $this->vehicle = Vehicle::findOrFail($vehicleId);
        $this->renewables = $this->vehicle->renewables()->with('documentType')->get();
    }
    public function render()
    {
        return view('livewire.vehicle-renewables')->layout('layouts.admin.admin');
    }
}
