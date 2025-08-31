<div class="p-6">
    {{-- Stats Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold">Total Vehicles</h2>
            <p class="text-3xl font-bold">{{ $totalVehicles }}</p>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold">Upcoming Renewals</h2>
            <p class="text-3xl font-bold">{{ $upcomingRenewals->count() }}</p>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold">Notifications</h2>
            <p class="text-3xl font-bold">{{ $notifications->count() }}</p>
        </div>
    </div>

    {{-- Upcoming Renewals Table --}}
    <div class="bg-white shadow p-4 rounded mb-6">
        <h2 class="text-lg font-semibold mb-2">Upcoming Renewals (Next 30 Days)</h2>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <td>S.N</td>
                    <th class="py-2">Vehicle</th>
                    <th class="py-2">Document</th>
                    <th class="py-2">Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingRenewals as $renewal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $renewal->vehicle->name }}</td>
                        <td>{{ $renewal->documentType->name }}</td>
                        <td>{{ $renewal->expired_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500">No upcoming renewals</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Notifications --}}
    <div class="bg-white shadow p-4 rounded mb-6">
        <h2 class="text-lg font-semibold mb-2">Recent Notifications</h2>
        <ul>
            @forelse($notifications as $notification)
                <li class="border-b py-2">{{ $notification->message }}</li>
            @empty
                <li class="text-gray-500">No notifications</li>
            @endforelse
        </ul>
    </div>

    {{-- Renewal History --}}
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-lg font-semibold mb-2">Renewal History</h2>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="py-2">Vehicle</th>
                    <th class="py-2">Document</th>
                    <th class="py-2">Renewal Date</th>
                    <th class="py-2">Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($renewalHistory as $history)
                    <tr>
                        <td>{{ $history->vehicle->name }}</td>
                        <td>{{ $history->documentType->name }}</td>
                        <td>{{ $history->renewable_date }}</td>
                        <td>{{ $history->expired_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500">No history available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
