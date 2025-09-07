<main class="main-content position-relative border-radius-lg ">
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
             <div class="p-4">
    <h2 class="text-xl font-bold mb-4 text-center">My Renewable Documents</h2>
   @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
               
            </div>
        @endif
    {{-- Add Button --}}
    <button wire:click="create" 
            class="btn btn-primary mb-3">
        <i class="ni ni-fat-add"></i> Add Document
    </button>
    {{-- Popup Modal --}}
    @if($isOpen)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content shadow-lg">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $renewable_id ? 'Edit Document' : 'Add Document' }}
                        </h5>
                        {{-- <button type="button" wire:click="$set('isOpen', false)" class="close">
                            <span>&times;</span>
                        </button> --}}
                    </div>

                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                        
                            <div class="form-group">
                                <label>Vehicle</label>
                                <select wire:model="vehicle_id" class="form-control">
                                    <option value="">-- Select Vehicle --</option>
                                    @foreach($allVehicles as $v)
                                        <option value="{{ $v->id }}">{{ $v->vehicle_number }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                          
                            <div class="form-group">
                                <label>Document Type</label>
                                <select wire:model="document_type_id" class="form-control">
                                    <option value="">-- Select Document --</option>
                                    @foreach($documentTypes as $dt)
                                        <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                           
                            <div class="form-group">
                                <label>Renewable Date</label>
                                <input type="date" wire:model="renewable_date" class="form-control"  max="{{ now()->toDateString() }}">
                                @error('renewable_date') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                              <div class="form-group">
                                <label>Duration (Months)</label>
                                 <input type="number" wire:model="duration" class="form-control" min="1" oninput="this.value = this.value < 1 ? '' : this.value" required>
                                   @error('duration') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>

                           
                            {{-- <div class="form-group">
                                <label>Expired Date</label>
                                <input type="date" wire:model="expired_date" class="form-control">
                                @error('expired_date') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="form-group form-check">
                                <input type="checkbox" wire:model="status" class="form-check-input" id="statusCheck">
                                <label for="statusCheck" class="form-check-label">Active</label>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" wire:click="$set('isOpen', false)" class="btn btn-secondary">Cancel</button>
                        <button type="submit" wire:click="save" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- <div class="modal fade @if($showRenewModal) show d-block @endif" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Renew Document</h5>
        <button type="button" class="close" wire:click="closeRenewModal">&times;</button>
      </div>

      <div class="modal-body">
        <label for="duration">Add Duration (months)</label>
        <input type="number" wire:model="renew_duration" class="form-control" placeholder="Enter months">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" wire:click="closeRenewModal">Cancel</button>
        <button type="button" class="btn btn-primary" wire:click="confirmRenewDuration">Renew</button>
      </div>

    </div>
  </div>
</div> --}}

    {{-- List Vehicles + Documents --}}
    @forelse($vehicles as $vehicle)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">
                     {{ $vehicle->vehicle_number }}
                    <small class="text-muted">({{ $vehicle->vehicleType->name?? '' }})</small>
                </h5>

                @forelse($vehicle->renewables as $renew)
                    <div class="border-top pt-2 mt-2">
                        <p class="mb-1">
                            <strong>📄 {{ $renew->documentType->name }}</strong>
                        </p>
                        <p class="mb-1">Renewable: {{ $renew->renewable_date }} → Expired: {{ $renew->expired_date }}</p>
                        <!-- #region -->
                        @php
                          $daysLeft = now()->diffInDays($renew->expired_date, false);
                          @endphp

                        {{-- Status --}}
                        @if($daysLeft < 0)
                        <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-sm font-semibold">❌ Expired</span>
                         @elseif($daysLeft <= 30)
                          <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-sm font-semibold">⚠️ Expiring Soon</span>
                        @else
                         <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-sm font-semibold">✅ Active</span>
                        @endif

                        {{-- Edit button --}}
                        <button wire:click="edit({{ $renew->id }})" 
                                class="btn btn-primary mb-3">
                            ✏️ Edit
                        </button>
                        {{-- <button   type="button" class="btn btn-primary mb-3" onclick="confirmRenew({{ $renew->id }})">
                            Renewable
                         </button> --}}
                       
                 {{-- <button  type="button" class="btn btn-primary mb-3"wire:click="openRenewModal({{ $renew->id }})">Renewable</button> --}}
                  <script>
                         function confirmRenew(id) {
                              if (confirm('Are you sure you want to renew this document?')) {
                                  Livewire.dispatch('renewDocument', { id: id });
                               }
                            }
                 </script>
                        <a href="{{ route('renewable.history', ['vehicle' => $vehicle->id, 'document' => $renew->document_type_id]) }}"
                         class="btn btn-primary mb-3">
                         📜 Show History
                        </a>
                    </div>

                            
                @empty
                    <p class="text-muted">No documents yet.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p class="text-muted">No vehicles found.</p>
    @endforelse
             </div>

           </div>
    </div>
</div>
{{-- <div class="mt-3">
    {{ $vehicles->links() }}
    </div> --}}
</main>
