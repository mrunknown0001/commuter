<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('commuter.home') }}"><strong>Commuter</strong></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ route('commuter.home') == url()->current() ? 'active' : '' }}"><a href="{{ route('commuter.home') }}"><i class="fa fa-home"></i> Home</a></li>
        
        <li class="dropdown {{ route('commuter.request.ride') == url()->current() || route('commuter.ride.history') == url()->current() ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-motorcycle"></i> Ride <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('commuter.request.ride') }}">Request Ride</a></li>
            <!-- <li role="separator" class="divider"></li>
            <li><a href="#">Active Ride</a></li> -->
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('commuter.ride.history') }}">Ride History</a></li>
          </ul>
        </li>

        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li> -->

      </ul>

<!--       <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> -->

      <ul class="nav navbar-nav navbar-right">
        <li class="{{ route('commuter.notification') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('commuter.notification') }}"><i class="fa fa-bell"></i> Notification</a>
        </li>

        <li class="dropdown {{ route('commuter.profile') == url()->current() ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('commuter.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>