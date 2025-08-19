<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VehicleType;

class VehicleTypeUser extends Component
{

     public $vehicleTypes;
    public $name;
    public $type_id;

    public function mount()
    {
        $this->loadVehicleTypes();
    }

    public function loadVehicleTypes()
    {
        $this->vehicleTypes = VehicleType::all();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->type_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255'
        ]);

        VehicleType::updateOrCreate(
            ['id' => $this->type_id],
            ['name' => $this->name]
        );

        session()->flash('message', $this->type_id ? 'Vehicle Type Updated' : 'Vehicle Type Created');
        $this->resetFields();
        $this->loadVehicleTypes();
    }

    public function edit($id)
    {
        $type = VehicleType::findOrFail($id);
        $this->type_id = $type->id;
        $this->name = $type->name;
    }

    public function delete($id)
    {
        VehicleType::findOrFail($id)->delete();
        session()->flash('message', 'Vehicle Type Deleted');
        $this->loadVehicleTypes();
    }

    public function render()
    {
        return view('livewire.vehicle-type')->layout('layouts.admin.admin');
    }
}
