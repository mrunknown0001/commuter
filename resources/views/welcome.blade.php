<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Welcome to Commuter Monitoring System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/full-bg.css') }}">
    <style type="text/css">
      li a {
        margin-top: 15px;
      }
      h1 {
        color: #fff;
        text-shadow: 2px 2px 4px #000000;
      }
      .container {
        margin-top: 250px;
      }
    </style>
  </head>
  <body>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <h1>Commuter Monitoring System</h1>
            <ul class="list-inline">
              <li><a href="{{ route('login') }}" class="btn btn-primary">Commuter &amp; Driver Login</a></li>
              <li><a href="{{ route('commuter.registration') }}" class="btn btn-primary">Commuter Registration</a></li>
              <li><a href="{{ route('driver.registration') }}" class="btn btn-primary">Driver Registration</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

  </body>
</html>
