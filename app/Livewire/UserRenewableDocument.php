<?php

namespace App\Livewire;

use App\Models\DocumentType;
use App\Models\Renewable;
use App\Models\RenewableHistory;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserRenewableDocument extends Component
{
    public $vehicles = [];
    
    public $renewable_id;
    public $vehicle_id;
    public $document_type_id;
    public $renewable_date;
    public $expired_date;
    public $status = true;
    public $duration;
    public $isOpen = false;
    public $documentTypes = [];

    public function mount()
    {
        $user = Auth::user();
        $this->loadData();
        $this->documentTypes = DocumentType::all();

        // Load vehicles with renewables, document type, and notifications
        $this->vehicles = Vehicle::with([
            'vehicleType',
            'renewables.documentType',
            'renewables.notifications',
            'renewables.renewableHistories'
        ])->where('user_id', $user->id)->get();
    }
    public function render()
    {
        return view('livewire.user-renewable-document',[
            'vehicles' => $this->vehicles,
        ])->layout('layouts.user.user');
    }
    public function loadData()
    {
        $userId = Auth::id();
        $this->vehicles = Vehicle::with([
            'vehicleType',
            'renewables.documentType',
            'renewables.notifications',
            'renewables.latestHistory'
        ])->where('user_id', $userId)->get();
    }
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }
    public function edit($id)
    {
        $renew = Renewable::findOrFail($id);
        $this->renewable_id    = $renew->id;
        $this->vehicle_id      = $renew->vehicle_id;
        $this->document_type_id= $renew->document_type_id;
        $this->renewable_date  = $renew->renewable_date;
        $this->expired_date    = $renew->expired_date;
        $this->status          = $renew->status;

        $this->isOpen = true;
    }
    public function save()
    {

        // Get document type duration (in months)
    $documentType = DocumentType::find($this->document_type_id);

    // If duration exists, auto-calculate expired_date
    // Auto-calculate expired_date if user entered duration
    if ($this->renewable_date && $this->duration) {
    $this->expired_date = Carbon::parse($this->renewable_date)
        ->addMonths((int) $this->duration) // ✅ cast to integer
        ->format('Y-m-d');
}
// dd($this->expired_date); // Debugging line, remove in production

        // $this->validate([
        //     'vehicle_id' => 'required|exists:vehicles,id',
        //     'document_type_id' => 'required|exists:document_types,id',
        //     'renewable_date' => 'required|date',
        //     'expired_date' => 'required|date|after:renewable_date',
        // ]);

         $renewable =Renewable::updateOrCreate(
            ['id' => $this->renewable_id],
            [
                'vehicle_id' => $this->vehicle_id,
                'document_type_id' => $this->document_type_id,
                'renewable_date' => $this->renewable_date,
                'expired_date' => $this->expired_date,
                'status' => $this->status,
            ]
        );
        RenewableHistory::create([
        'renewable_id'     => $renewable->id,
        'vehicle_id'       => $this->vehicle_id,
        'document_type_id' => $this->document_type_id,
        'renewable_date'   => $this->renewable_date,
        'expired_date'     => $this->expired_date,
    ]);


        session()->flash('success', 'Document saved successfully ✅');
        $this->resetForm();
        $this->isOpen = false;
        $this->loadData(); // refresh list
    }
    public function resetForm()
    {
        $this->renewable_id = null;
        $this->vehicle_id = '';
        $this->document_type_id = '';
        $this->renewable_date = '';
        $this->expired_date = '';
        $this->status = true;
    }

}
