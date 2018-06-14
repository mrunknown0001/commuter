<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Commuter Queuing System</title>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                font-weight: 100;
                height: 80vh;
                margin: 0;
            }

            .full-height {
                height: 80vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }


            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="m-b-md">
                    <h1>Commuter Monitoring System</h1>
                </div>

                <div class="links">
                    <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Commuter &amp; Driver Login</a>
                    <a href="{{ route('commuter.registration') }}" class="btn btn-lg btn-primary">Commuter Registration</a>
                    <a href="{{ route('driver.registration') }}" class="btn btn-lg btn-primary">Driver Registration</a>
                </div>
            </div>
        </div>
    </body>
</html>
