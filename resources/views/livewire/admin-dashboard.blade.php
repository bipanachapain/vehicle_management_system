<div class="p-6 space-y-8">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
            <p class="text-lg">Total Users</p>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
            <p class="text-lg">Total Vehicles</p>
            <p class="text-3xl font-bold">{{ $totalVehicles }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
            <p class="text-lg">Upcoming Renewals</p>
            <p class="text-3xl font-bold">{{ $upcomingRenewals->count() }}</p>
        </div>
        <div class="bg-red-500 text-white p-6 rounded-lg shadow">
            <p class="text-lg">Expired Documents</p>
            <p class="text-3xl font-bold">{{ $expiredDocuments->count() }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Vehicles by Type</h2>
            <canvas id="vehiclesChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Renewals Timeline</h2>
            <canvas id="renewalsChart"></canvas>
        </div>
    </div>

    {{-- Upcoming Renewals Table --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Upcoming Renewals (Next 30 Days)</h2>
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Vehicle</th>
                    <th class="p-2 border">Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingRenewals as $renewal)
                    <tr>
                        <td class="p-2 border">{{ $renewal->vehicle->name }}</td>
                        <td class="p-2 border">{{ $renewal->Expired_date }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center p-2">No upcoming renewals</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Notifications --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Recent Notifications</h2>
        <ul class="space-y-2">
            @foreach($notifications as $note)
                <li class="p-3 bg-gray-50 rounded">{{ $note->message }}</li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const vehiclesChart = new Chart(document.getElementById('vehiclesChart'), {
        type: 'pie',
        data: {
            labels: @json(array_keys($vehiclesByType->toArray())),
            datasets: [{
                data: @json($vehiclesByType->map->count()->values()),
                backgroundColor: ['#3B82F6','#10B981','#F59E0B','#EF4444'],
            }]
        }
    });

    const renewalsChart = new Chart(document.getElementById('renewalsChart'), {
        type: 'line',
        data: {
            labels: @json($renewalsTimeline['dates']),
            datasets: [{
                label: 'Renewals',
                data: @json($renewalsTimeline['counts']),
                borderColor: '#3B82F6',
                fill: false
            }]
        }
    });
</script>
@endpush

