<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class VehicleLivewire extends Component
{
     public $vehicles, $id, $user_id, $vehicle_type_id, $name, $purchase_date;
    public $isOpen = false;

    public function render()
    {
        $this->vehicles = Vehicle::with('vehicleType', 'user')->get();
        return view('livewire.vehicle', [
            'vehicleTypes' => VehicleType::all(),
           
        ])->layout('layouts.user.user');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal() { $this->isOpen = true; }
    public function closeModal() { $this->isOpen = false; }

    public function resetFields()
    {
        $this->id = '';
        $this->user_id = '';
        $this->vehicle_type_id = '';
        $this->name = '';
        $this->purchase_date = '';
    }

    public function store()
    {
        
        // $this->validate([
        //       'id' => 'required|unique:vehicles,id',
        //     'user_id' => 'required|exists:users,id',
        //     'vehicle_type_id' => 'required|exists:vehicle_types,id',
        //     'name' => 'required',
        //     'purchase_date' => 'required|date'
        // ]);
// dd($this->all());
        Vehicle::updateOrCreate(['id' => $this->id], [
             'user_id' => Auth::id(),
             'vehicle_type_id' => $this->vehicle_type_id,
            'name' => $this->name,
            'purchase_date' => $this->purchase_date
        ]);

        session()->flash('message', $this->id ? 'Vehicle updated.' : 'Vehicle created.');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->id = $id;
        $this->user_id = $vehicle->user_id;
        $this->vehicle_type_id = $vehicle->vehicle_type_id;
        $this->name = $vehicle->name;
        $this->purchase_date = $vehicle->purchase_date;

        $this->openModal();
    }

    public function delete($id)
    {
        Vehicle::findOrFail($id)->delete();
        session()->flash('message', 'Vehicle deleted.');
    }
}
