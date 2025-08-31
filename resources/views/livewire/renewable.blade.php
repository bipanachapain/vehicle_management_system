<main class="main-content position-relative border-radius-lg ">
<div class="container-fluid py-4">
     @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                
            </div>
        @endif
    <div class="row">
        <div class="col-12">    
<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Renewable Documents</h5>
        <button wire:click="create" class="btn btn-primary btn-sm">
            <i class="ni ni-fat-add"></i> Add Renewable
        </button>
    </div>

    <div class="card-body">
        {{-- Modal Popup Form --}}
        @if($isOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Renewable</h5>
                        {{-- <button type="button" class="btn-close" wire:click="closeModal"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle</label>
                                <select wire:model="vehicle_id" class="form-control">
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Document Type</label>
                                <select wire:model="document_type_id" class="form-control">
                                    <option value="">Select Document Type</option>
                                    @foreach($documentTypes as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                              <label class="form-label">Renewable Date</label>
                                <input type="date" wire:model="renewable_date" class="form-control" required>
                                   @error('renewable_date') 
                                         <span class="text-danger">{{ $message }}</span> 
                                     @enderror
                                </div>


                            {{-- <div class="col-md-6">
                                <label class="form-label">Expired Date</label>
                                <input type="date" wire:model="expired_date" class="form-control">
                                @error('expired_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="col-md-6 d-flex align-items-center mt-2">
                                <div class="form-check">
                                    <input type="checkbox" wire:model="status" class="form-check-input" id="statusCheck">
                                    <label class="form-check-label" for="statusCheck">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button class="btn btn-success" wire:click="store">Save</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Table --}}
        <div class="table-responsive mt-3">
            <table class="table table-hover align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th>Vehicle</th>
                        <th>Document Type</th>
                        <th>Renewable Date</th>
                        <th>Expired Date</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($renewables as $r)
                        <tr>
                            <td class="text-sm">{{ $r->vehicle?->name ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $r->documentType?->name ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $r->renewable_date }}</td>
                            <td class="text-sm">{{ $r->expired_date }}</td>
                            <td class="text-sm">
                                @if($r->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button wire:click="edit({{ $r->id }})" class="btn btn-sm btn-warning">
                                    <i class="ni ni-ruler-pencil"></i>Edit
                                </button>
                                <button wire:click="delete({{ $r->id }})" class="btn btn-sm btn-danger">
                                    <i class="ni ni-fat-remove"></i>Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

 </div>
    </div>
</div>
</main>
