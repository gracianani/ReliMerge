<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            {{ $heatsource->heatsource_name }}
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>