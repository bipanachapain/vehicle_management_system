<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}">
    @livewireStyles
</head>
<body>
    <!-- Sidebar -->
    @include('layouts.admin.partials.sidebar')

    

        <!-- Navbar -->
        @include('layouts.admin.partials.navbar')

        <!-- Page Content -->
        <div class="container-fluid mt-4">
            {{ $slot }}
        </div>

  
@include('layouts.admin.partials.footer')
    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    @livewireScripts
</body>
</html>
