<?php

namespace App\Livewire;

use App\Models\DocumentType;
use App\Models\Renewable;
use App\Models\Vehicle;
use Livewire\Component;
use Carbon\Carbon;

class RenewableLivewire extends Component
{
    public $vehicles = [];
    public $documentTypes = [];
    public $renewables = [];
    public $renewId;
    public $vehicle_id;
    public $document_type_id;
    public $renewable_date;
    public $expired_date;
    public $status = false;
    public $isOpen = false;


    
    public function mount()
    {
        $this->vehicles = Vehicle::all();
        $this->documentTypes = DocumentType::all();
        $this->renewables = Renewable::with(['vehicle', 'documentType'])->get();
    }
    public function render()
    {
        return view('livewire.renewable')->layout('layouts.admin.admin');
    }


    public function updatedDocumentTypeId($value)
    {
        $this->calculateExpiredDate();
    }
     public function updatedRenewableDate($value)
    {
        $this->calculateExpiredDate();
    }
    public function calculateExpiredDate()
    {
        if ($this->renewable_date && $this->document_type_id) {
            $doc = DocumentType::find($this->document_type_id);
            if ($doc) {
                $this->expired_date = Carbon::parse($this->renewable_date)
                                            ->addMonths($doc->duration)
                                            ->format('Y-m-d');
            }
        } else {
            $this->expired_date = null;
        }
    }
    public function create()
    {
        $this->resetFields();
        $this->renewable_date = now()->format('Y-m-d'); 
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'document_type_id' => 'required|exists:document_types,id',
            'renewable_date' => 'required|date',
            'expired_date' => 'required|date|after_or_equal:renewable_date',
            'status' => 'boolean'
        ]);
       

        if (!$this->expired_date && $this->renewable_date && $this->document_type_id) {
        $doc =DocumentType::find($this->document_type_id);
        if ($doc) {
            $this->expired_date = Carbon::parse($this->renewable_date)
                ->addMonths($doc->duration)
                ->format('Y-m-d');
        }
    }
        //  dd($this->renewable_date, $this->document_type_id, $this->expired_date);
      
        Renewable::updateOrCreate(['id' => $this->renewId], [
            'vehicle_id' => $this->vehicle_id,
            'document_type_id' => $this->document_type_id,
            'renewable_date' => $this->renewable_date,
            'expired_date' => $this->expired_date,
            'status' => $this->status ?? true
        ]);
          $this->renewables = Renewable::with(['vehicle', 'documentType'])->get();
           $this->isOpen = false; 
           $this->reset(['vehicle_id', 'document_type_id', 'renewable_date', 'expired_date', 'status']); // Reset form
           $this->emit('refreshTable');
            $this->closeModal();
    }

    public function edit($id)
    {
        $renew = Renewable::findOrFail($id);
        $this->renewId = $renew->id;
        $this->vehicle_id = $renew->vehicle_id;
        $this->document_type_id = $renew->document_type_id;
        $this->renewable_date = $renew->renewable_date;
        $this->expired_date = $renew->expired_date;
        $this->status = $renew->status;
        $this->isOpen = true;
    }

    public function delete($id)
    {
        Renewable::findOrFail($id)->delete();
    }
    
    public function closeModal()
    {
       $this->isOpen = false; // Hide form
    }

    private function resetFields()
    {
        $this->vehicle_id = '';
        $this->document_type_id = '';
        $this->renewable_date = '';
        $this->expired_date = '';
        $this->status = true;
        $this->renewId = null;
    }
}
