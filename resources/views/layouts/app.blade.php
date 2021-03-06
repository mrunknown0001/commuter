<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | Commuter Monitoring System</title>

        <!--Admin Theme-->
        <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">

        <!-- AdminLTE Skin -->
        <link rel="stylesheet" href="{{ asset('adminlte/css/skins/skin-blue-light.min.css') }}">

        <!-- Bootstrap 3.3.7 && Fontawesome -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

        <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('rating/css/star-rating.min.css') }}">
        <script type="text/javascript" src="{{ asset('rating/js/star-rating.min.js') }}"></script>
    </head>
    <body class="skin-blue-light">
        @yield('content')
        
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <div id="drop-off-prompt"></div>
        @if(Auth::check())
        <script>
            setInterval(function () {
                $('.notification').load("{{ route('commuter.notification.new') }}");

                $('#notif-badge').load("{{ route('commuter.notification.new.count') }}");


                $('#ride-request').load("{{ route('driver.ride.request.new') }}");
            }, 3000);

            setInterval(function () {
                // check if there is accepted ride request for the current user
                // and create notification for pickup confirmation
                $.get("{{ route('commuter.create.pickup.notification') }}");

                $.get("{{ route('commuter.create.dropoff.notification') }}");


                // check if there is current ride
                // ask if already drop off
            }, 900000);

        </script>
        @endif
    </body>
</html>
