<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ mix('ui/js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="{{ mix('ui/css/app.css') }}" rel="stylesheet" />

        <script>
            window.App = {user: @json(Auth::user()) };
        </script>
    </head>
    <body class="tw-bg-gray-200">
        <div id="app">
            @yield('content')
        </div>
    </body>
</html>
