<main class="main-content position-relative border-radius-lg ">
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="p-4">
    <h2 class="text-xl font-bold mb-4">Recent Notifications</h2>

    @forelse($notifications as $notification)
        <div class="border p-3 rounded mb-2">
            <p>{{ $notification->message }}</p>
            <small class="text-gray-500">
                {{ $notification->created_at->diffForHumans() }}
            </small>
        </div>
    @empty
        <p class="text-gray-500">No recent notifications.</p>
    @endforelse
</div>

        </div>
    </div>
</div>
</main>
