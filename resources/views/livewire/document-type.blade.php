
<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
             @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                
            </div>
        @endif

            <!-- Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Document Types</h5>
                    <button wire:click="create" class="btn btn-primary btn-sm">
                        <i class="ni ni-fat-add"></i> Add New
                    </button>
                </div>

                <div class="card-body px-4 py-3">
                    <!-- Table -->
                    <div class="table-responsive mt-3">
                       <table class="table table-hover align-items-center">
                         <thead class="thead-light">
                            <tr>
                                <th>S.N</th>
                                    <th >Name</th>
                                    <th >Duration</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documentTypes as $doc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-sm">{{ $doc->name }}</td>
                                        <td class="text-sm">{{ $doc->duration }}</td>
                                        <td class="text-end">
                                            <button wire:click="edit({{ $doc->id }})" class="btn btn-warning btn-sm">
                                                <i class="ni ni-ruler-pencil">Edit</i>
                                            </button>
                                            {{-- <button wire:click="delete({{ $doc->id }})" class="btn btn-danger btn-sm">
                                                <i class="ni ni-fat-remove">Delete</i>
                                            </button> --}}
                                            <button 
                                              onclick="if (confirm('Are you sure you want to delete this vehicle?')) { @this.delete('{{ $doc->id}}') }" 
                                               class="btn btn-danger btn-sm">
                                                 <i class="ni ni-fat-remove">Delete</i>
                                                </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No document types found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            @if($isOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $editMode ? 'Edit' : 'Create' }} Document Type</h5>
                                {{-- <button type="button" class="btn-close" wire:click="closeModal"></button> --}}
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" wire:model="name" class="form-control">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Duration</label>
                                    <input type="number" wire:model="duration" class="form-control">
                                    @error('duration') <small class="text-danger">{{ $message }}</small> @enderror
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

        </div>
    </div>
</div>

      
</main>

