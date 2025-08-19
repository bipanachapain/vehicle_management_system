<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="flex bg-gray-100 min-h-screen">

    {{-- Sidebar --}}
    <div class="w-64 bg-white shadow fixed top-0 left-0 h-screen p-4 flex flex-col overflow-y-auto hidden md:flex">
        <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-200">Dashboard</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200">Manage Users</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200">Manage Vehicles</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200">Renewals</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200">Notifications</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200">Reports</a>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 md:ml-64 p-6">
        {{-- Top Navbar --}}
        <div class="flex justify-end items-center mb-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ auth()->user()->name }}
                        <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile')" wire:navigate>
                        Profile
                    </x-dropdown-link>
                   <form method="POST" action="{{ route('logout') }}">
                   @csrf
                    <button type="submit" class="w-full text-start block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                     Log Out
                       </button>
                     </form>
                </x-slot>
            </x-dropdown>
        </div>

        {{-- Page Content --}}
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
