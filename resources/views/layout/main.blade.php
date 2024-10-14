<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>

        <!-- CSS here -->


        <!-- JS here -->


        <!-- Metatags here -->


    </head>
    
    <body>
        <!-- Header template here-->
        @include('template.header')

        <!-- Main content will be displayed here -->
        <div class="container">
            @yield('content')
        </div>

        <!-- Footer template here-->
        @include('template.footer')
    </body>
</html>