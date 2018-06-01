<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') | {{ env('app_name') }}</title>

        <!-- Bootstrap 3.3.7 && Fontawesome -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

    </head>
    <body>
 
        @yield('content')

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
