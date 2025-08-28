<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
<div class="container-fluid mt-4">
    <button wire:click="create" class="btn btn-primary mb-3">Add Vehicle</button>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
{{-- 
     @if($isOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        <div class="modal-header form-group w-75 mx-auto">
                            <h5 class="modal-title"><i class="ni ni-fat-add">Add Vehicle</h5>
                            <button type="button" wire:click="closeModal" class="close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           
                            <div class="form-group">
                                <label>Vehicle Number</label>
                               <input type="text" wire:model="vehicle_number" class="form-control">
                                @error('vehicle_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                           
                            <div class="form-group">
                                <label>Vehicle Type</label>
                                <select wire:model="vehicle_type_id" class="form-control">
                                    <option value="">-- Select Vehicle Type --</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                 @error('vehicle_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            
                            <div class="form-group">
                                <label>Vehicle Name</label>
                                <input type="text" wire:model="name" class="form-control">
                                 @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input type="date" wire:model="purchase_date" class="form-control">
                                 @error('Purchase_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif --}}
      @if($isOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $editMode ? 'Edit' : 'Create' }} Vehicle</h5>
                                <button type="button" class="btn-close" wire:click="closeModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Vehicle Number</label>
                                    <input type="text" wire:model="vehicle_number" class="form-control">
                                    @error('vehicle_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Vehicle Type</label>
                                    <select wire:model="vehicle_type_id" class="form-control">
                                        <option value="">-- Select Vehicle Type --</option>
                                        @foreach($vehicleTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Vehicle Name</label>
                                    <input type="text" wire:model="name" class="form-control">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Purchase Date</label>
                                    <input type="date" wire:model="purchase_date" class="form-control">
                                    @error('purchase_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                                <button class="btn btn-primary" wire:click="store">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

    {{-- Vehicle Table --}}
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Vehicle Number</th>
                        <th>Vehicle Type</th>
                        <th>Name</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->vehicle_number }}</td>
                            <td>{{ $vehicle->vehicleType->name }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->purchase_date }}</td>
                            <td>
                                <button wire:click="edit({{ $vehicle->id }})" class="btn btn-warning btn-sm">Edit</button>
                               <button 
    onclick="if (confirm('Are you sure you want to delete this vehicle?')) { @this.delete('{{ $vehicle->id }}') }" 
    class="btn btn-danger btn-sm">
    Delete
</button>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>
    </div>
</div>

      
</main>
