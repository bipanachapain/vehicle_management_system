<?php

namespace App\Livewire;

use App\Models\DocumentType;
use App\Models\Vehicle;
use Livewire\Component;

class RenewableHistory extends Component
{

     public $vehicle;
    public $document;
    public $histories = [];
    public function mount($vehicle, $document)
    {
        $this->vehicle = Vehicle::findOrFail($vehicle);
        $this->document = DocumentType::findOrFail($document);

        // Load history for this vehicle + document type
        $renewable = $this->vehicle->renewables()
            ->where('document_type_id', $this->document->id)
            ->first();

        $this->histories = $renewable
            ? $renewable->renewableHistories()->latest()->get()
            : collect();
    }
    public function render()
    {
        return view('livewire.renewable-history')->layout('layouts.user.user');
    }
}
