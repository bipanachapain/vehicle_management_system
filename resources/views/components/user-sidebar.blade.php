<div class="w-64 bg-gray-800 text-white h-screen p-4 flex flex-col">
    <h2 class="text-2xl font-bold mb-8">User Panel</h2>
    <nav class="space-y-4">
        <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a>
        <a href="{{ route('user.vehicles') }}" class="block px-3 py-2 rounded hover:bg-gray-700">My Vehicles</a>
        <a href="{{ route('user.renewals') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Renewals</a>
        <a href="{{ route('user.notifications') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Notifications</a>
        <a href="{{ route('user.profile') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block w-full text-left px-3 py-2 rounded hover:bg-gray-700">Logout</button>
        </form>
    </nav>
</div>
