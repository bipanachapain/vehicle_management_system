   @include('layouts.user.partials.header')

   @include('layouts.user.partials.aside')  
  
        
            {{ $slot }}

    @include('layouts.user.partials.footer')
