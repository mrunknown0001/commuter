<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Welcome to Commuter Monitoring System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
      .masthead {
        min-height: 30rem;
        position: relative;
        display: table;
        width: 100%;
        height: auto;
        padding-top: 20rem;
        padding-bottom: 8rem;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
      }
      .masthead h1 {
        font-size: 4rem;
        margin: 0;
        padding: 0;
      }
      @media (min-width: 992px) {
        .masthead {
          height: 100vh;
        }
        .masthead h1 {
          font-size: 5.5rem;
        }
      }
      @media (max-width: 600px) {
        li {
            height: 30px;
            line-height: 30px;
            padding: 20px;
        }
      }
    </style>
  </head>
  <body>
    <header class="masthead d-flex">
      <div class="container text-center my-auto">
        <h1 class="">Commuter Queuing System</h1>
        <h3 class="mb-5">
        </h3>
        <ul class="list-inline">
          <li><a href="{{ route('login') }}" class="btn btn-primary">Commuter &amp; Driver Login</a></li>
          <li><a href="{{ route('commuter.registration') }}" class="btn btn-primary">Commuter Registration</a></li>
          <li><a href="{{ route('driver.registration') }}" class="btn btn-primary">Driver Registration</a></li>
        </ul>
      </div>
      <div class="overlay"></div>
    </header>
  </body>
</html>
