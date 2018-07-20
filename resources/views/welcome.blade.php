<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Welcome</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">

  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}" />

  <!-- Owl Carousel -->
  <link type="text/css" rel="stylesheet" href="{{ asset('landing/css/owl.carousel.css') }}" />
  <link type="text/css" rel="stylesheet" href="{{ asset('landing/css/owl.theme.default.css') }}" />

  <!-- Magnific Popup -->
  <link type="text/css" rel="stylesheet" href="{{ asset('landing/css/magnific-popup.css') }}" />

  <!-- Custom stlylesheet -->
  <link type="text/css" rel="stylesheet" href="{{ asset('landing/css/style.css') }}" />

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
    a {
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <header id="home">
    <div class="bg-img" style="background-image: url('/uploads/bg.jpg');">
      <div class="overlay"></div>
    </div>
    
    <div class="home-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="home-content">
              <h1 class="white-text">Commuter Queuing System</h1>
              <!-- <p class="white-text">App Description</p> -->
              <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Commuter &amp; Driver Login</a>
              <a href="{{ route('commuter.registration') }}" class="btn btn-primary btn-lg">Commuter Registration</a>
              <a href="{{ route('driver.registration') }}" class="btn btn-primary btn-lg">Driver Registration</a>
            </div>
          </div>

        </div>
      </div>
    </div>

  </header>

  <script src="{{ asset('js/jquery.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/owl.carousel.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/jquery.magnific-popup.js') }}"></script>
  <script type="text/javascript" src="{{ asset('landing/js/main.js') }}"></script>

</body>
</html>
