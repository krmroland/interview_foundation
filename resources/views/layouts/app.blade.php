<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ mix('ui/js/app.js') }}" defer></script>

       
               <!-- Styles -->
        <link href="{{ mix('ui/css/app.css') }}" rel="stylesheet" />

    </head>
    <body>
        <script>
            window.App = {user: @json(Auth::user()) };
        </script>
        <div id="app">
            @yield('content')
        </div>
    </body>
</html>
