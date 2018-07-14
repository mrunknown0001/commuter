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
  </head>
  <body>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
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
