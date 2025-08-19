<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
<div class="container-fluid mt-4">
    <button wire:click="create" class="btn btn-primary mb-3">Add Vehicle</button>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if($isOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Vehicle</h5>
                            <button type="button" wire:click="closeModal" class="close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- Vehicle Number --}}
                            <div class="form-group">
                                <label>Vehicle Number</label>
                                <input type="text" wire:model="id" class="form-control">
                            </div>

                            {{-- Vehicle Type --}}
                            <div class="form-group">
                                <label>Vehicle Type</label>
                                <select wire:model="vehicle_type_id" class="form-control">
                                    <option value="">-- Select Vehicle Type --</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Name --}}
                            <div class="form-group">
                                <label>Vehicle Name</label>
                                <input type="text" wire:model="name" class="form-control">
                            </div>

                            {{-- Purchase Date --}}
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input type="date" wire:model="purchase_date" class="form-control">
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
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->vehicleType->name }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->purchase_date }}</td>
                            <td>
                                <button wire:click="edit({{ $vehicle->id }})" class="btn btn-warning btn-sm">Edit</button>
                                <button wire:click="delete({{ $vehicle->id }})" class="btn btn-danger btn-sm">Delete</button>
                            </td>
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
