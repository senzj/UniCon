<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Web | @yield('title', 'Page')</title>

        <!-- CSS here -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Toastr CSS for alert -->
        
        <!-- Custom css from public folder -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </head>
    
    <body>

        <!-- Header template here-->
        @include('layouts.header')

        <!-- Main content will be displayed here -->
        <div class="container">
            @yield('content')
        </div>

        <!-- Footer template here-->
        @include('layouts.footer')

        <!-- JS here -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Toastr JS for alert -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        
        <!-- Display Alert -->
        @if (Session::has('error'))
        <script>
            toastr.error("{{ session()->get('error') }}", "Error!", 20000);
        </script>
        @elseif (Session::has('success'))
        <script>
            toastr.success("{{ session()->get('success') }}", "Success!", 20000);
        </script>
        @elseif (Session::has('message'))
        <script>
            toastr.info("{{ session()->get('message') }}", 20000);
        </script>
        @endif
    </body>
</html>