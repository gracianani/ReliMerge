<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            {{ implode(',', $heatsource->getAllColumnsNames() )}}
            <br/>
            {{ $heatsource->heatsource_name }}
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>