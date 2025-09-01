<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

          <div>
         <div class="card shadow mb-4">
        <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-center">Messages Management</h3>
            <button wire:click="openModal()" class="btn btn-primary">Add Message</button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Grouped Messages by Document Type -->
            @forelse($documentTypes as $docType)
                <div class="mb-4">
                    <h5 class="fw-bold text-primary">
                        📂 {{ $docType->name }}
                    </h5>
                    <ul>
    @forelse($docType->messages as $msg)
        <li class="d-flex justify-content-between align-items-center">
            {{ $msg->message }}
            <span>
                <button wire:click="edit({{ $msg->id }})" class="btn btn-sm btn-warning">Edit</button>
                <button wire:click="delete({{ $msg->id }})" class="btn btn-sm btn-danger">Delete</button>
            </span>
        </li>
    @empty
        <li class="text-muted">No messages for this document type</li>
    @endforelse
</ul>
                </div>
            @empty
                <p class="text-muted">No document types found.</p>
            @endforelse
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade @if($isModalOpen) show d-block @endif" tabindex="-1" style="@if($isModalOpen) display: block; @else display: none; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $updateMode ? 'Edit Message' : 'Add Message' }}</h5>
                    {{-- <button type="button" class="btn-close" wire:click="closeModal()"></button> --}}
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <input type="text" wire:model="message" class="form-control" placeholder="Enter message">
                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Document Type</label>
                            <select wire:model="document_type_id" class="form-control">
                                <option value="">Select Document Type</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('document_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">{{ $updateMode ? 'Update' : 'Save' }}</button>
                            <button type="button" wire:click="closeModal()" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($isModalOpen)
        <div class="modal-backdrop fade show"></div>
    @endif
          </div>

</div>
    </div>
</div>

      
</main>