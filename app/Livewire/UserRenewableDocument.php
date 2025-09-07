<?php

namespace App\Livewire;

use App\Models\DocumentType;
use App\Models\Renewable;
use App\Models\RenewableHistory;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

class UserRenewableDocument extends Component
{
    use WithPagination;
    public $vehicles = [];
    
    public $renewable_id;
    public $vehicle_id;
    public $document_type_id;
    public $renewable_date;
    public $expired_date;
    public $status = true;
    public $duration;
    public $isOpen = false;
    public  $showRenewModal = false;
    public  $newdurtaion;
    public $documentTypes = [];

    public function mount()
    {
        $user = Auth::user();
        $this->loadData();
        $this->documentTypes = DocumentType::all();

        // Load vehicles with renewables, document type, and notifications
    //     $this->vehicles = Vehicle::with([
    //         'vehicleType',
    //         'renewables.documentType',
    //         'renewables.notifications',
    //         'renewables.renewableHistories'
    //     ])->where('user_id', $user->id)->get();
    }
    public function render()
    {

        $vehicles = Vehicle::with([
        'vehicleType',
        'renewables.documentType',
        'renewables.notifications',
        'renewables.renewableHistories'
    ])->where('user_id', Auth::id())->paginate(5);

    $allVehicles = Vehicle::where('user_id', Auth::id())->get();
    //  dd(    $vehicles);
    $documentTypes = DocumentType::all();

    return view('livewire.user-renewable-document', compact('vehicles', 'allVehicles', 'documentTypes'))
        ->layout('layouts.user.user');
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
   
    $documentType = DocumentType::find($this->document_type_id);

    if ($this->renewable_date && $this->duration) {
    $this->expired_date = Carbon::parse($this->renewable_date)
        ->addMonths((int) $this->duration) 
        ->format('Y-m-d');
}
// dd($this->expired_date); 

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
        session()->flash('message', 'Document saved successfully ✅');
        
        $this->resetForm();
        $this->isOpen = false;

        $this->loadData();
    }
    public function openRenewModal($id)
{
    $this->renewable_id = $id;
    $this->renew_duration = null;
    $this->showRenewModal = true;
}

public function closeRenewModal()
{
    $this->showRenewModal = false;
}

public function confirmRenewDuration()
{
    $renew = Renewable::find($this->renewable_id);

    if ($renew && $this->renew_duration > 0) {
        // Extend expiry date
        $renew->expired_date = Carbon::parse($renew->expired_date)->addMonths($this->renew_duration);
        $renew->save();

        // Save to history
        RenewableHistory::create([
            'renewable_id'     => $renew->id,
            'vehicle_id'       => $renew->vehicle_id,
            'document_type_id' => $renew->document_type_id,
            'renewable_date'   => now(),
            'expired_date'     => $renew->expired_date,
        ]);

        session()->flash('message', "Document renewed for {$this->renew_duration} months ✅");

        $this->closeRenewModal();
        $this->loadData();
    } else {
        session()->flash('error', 'Please enter a valid duration ❌');
    }
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
