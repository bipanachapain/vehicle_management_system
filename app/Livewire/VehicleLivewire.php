<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class VehicleLivewire extends Component
{
     public $vehicles,$vehicle_number, $id, $user_id, $vehicle_type_id, $name, $purchase_date;
    public $isOpen = false;
    public $editMode = false;

    public function render()
    {
       $userVehicles = Vehicle::with('vehicleType', 'user')
    ->where('user_id', Auth::id())  
    ->paginate(5);
        $vehicleTypes = VehicleType::all();
        return view('livewire.vehicle', compact('userVehicles','vehicleTypes'))->layout('layouts.user.user');
    }

    public function create()
    {
        $this->resetFields();
          $this->id = null;
        $this->editMode = false;
        $this->openModal();
    }

    public function openModal() { $this->isOpen = true; }
    public function closeModal() { $this->isOpen = false; }

    public function resetFields()
    {
        $this->vehicle_number = '';
        $this->user_id = '';
        $this->vehicle_type_id = '';
        $this->name = '';
        $this->purchase_date = '';
    }

//     public function store()
//     {
        
//         $this->validate([
//               'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number',
//               'vehicle_type_id' => 'required|exists:vehicle_types,id',
//               'name' => 'required',
//               'purchase_date' => 'required|date'
//         ]);
// // dd($this->all());
//         Vehicle::updateOrCreate(['id' => $this->id], [
//             'vehicle_number'=> $this->vehicle_number, 
//             'user_id' => Auth::id(),
//              'vehicle_type_id' => $this->vehicle_type_id,
//             'name' => $this->name,
//             'purchase_date' => $this->purchase_date
//         ]);

//         session()->flash('message', $this->id ? 'Vehicle updated.' : 'Vehicle created.');
//         $this->closeModal();
//         $this->resetFields();
//     }

public function store()
{
    if ($this->id) {
        // Update
        $this->validate([
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'name' => 'required',
            'purchase_date' => 'required|date'
        ]);

        $vehicle = Vehicle::findOrFail($this->id);
        $vehicle->update([
            // 'vehicle_number' => $this->vehicle_number, // 🚫 Do not update vehicle_number
            'vehicle_type_id' => $this->vehicle_type_id,
            'name' => $this->name,
            'purchase_date' => $this->purchase_date
        ]);

        session()->flash('message', 'Vehicle updated.');
    } else {
        // Create
        $this->validate([
            'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'name' => 'required',
           'purchase_date' => 'required|date|before_or_equal:' . Carbon::today()->toDateString(),
        ]);

        Vehicle::create([
            'vehicle_number'=> $this->vehicle_number, 
            'user_id' => Auth::id(),
            'vehicle_type_id' => $this->vehicle_type_id,
            'name' => $this->name,
            'purchase_date' => $this->purchase_date
        ]);

        session()->flash('message', 'Vehicle created.');
    }

    $this->closeModal();
    $this->resetFields();
}
    
public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->id = $id;
        $this->vehicle_number = $vehicle->vehicle_number;
        $this->user_id = $vehicle->user_id;
        $this->vehicle_type_id = $vehicle->vehicle_type_id;
        $this->name = $vehicle->name;
        $this->purchase_date = $vehicle->purchase_date;

        $this->editMode = true; 
        $this->openModal();
    }

    public function delete($id)
    {
        Vehicle::findOrFail($id)->delete();
        session()->flash('message', 'Vehicle deleted.');
    }
}
