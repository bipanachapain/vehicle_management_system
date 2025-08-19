<main class="main-content position-relative border-radius-lg ">
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
                 <div class="p-6">
                      <h3 class="text-xl font-bold mb-4">
                          📜 History for {{ $vehicle->name }} ({{ $document->name }})
                       </h3>
 
                        @forelse($histories as $history)
                         <div class="border rounded p-3 mb-2 bg-gray-50 shadow-sm">
                         <p>
                          <strong>{{ $loop->iteration }}</strong>  
                             Renewable: {{ $history->renewable_date }} → Expired: {{ $history->expired_date }}
                         </p>
                          <small class="text-gray-600">
                           Recorded: {{ $history->created_at->format('Y-m-d H:i') }}
                          </small>
                           </div>
                        @empty
                        <p class="text-gray-500">No history found.</p>
                        @endforelse

                      <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">⬅️ Back</a>
                   </div>

       </div>
    </div>
</div>

      
</main>