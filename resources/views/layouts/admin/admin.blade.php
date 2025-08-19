<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}">
    @livewireStyles
</head>
<body class="g-sidenav-show   bg-gray-100" >
    <!-- Sidebar -->
    @include('layouts.admin.partials.aside')

    

        <!-- Navbar -->
        @include('layouts.admin.partials.nav')

        <!-- Page Content -->
        
            {{ $slot }}
      

  @include('layouts.admin.partials.footer')

    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    @livewireScripts
</body>
</html>
