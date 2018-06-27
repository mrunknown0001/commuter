<header class="main-header">
  <!-- LOGO -->
  <a href="{{ route('driver.home') }}" class="logo">Driver</a>

  <nav class="navbar navbar-static-top" role="navigation">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1" aria-expanded="false">
        <i class="fa fa-bars"></i>
        
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse1">
      <ul class="nav navbar-nav">
        <li class="{{ route('driver.home') == url()->current() ? 'active' : '' }}"><a href="{{ route('driver.home') }}"><i class="fa fa-home"></i> Home</a></li>


        <li class="dropdown {{ route('driver.ride.request') == url()->current() || route('driver.ride.history') == url()->current() || route('driver.accept.ride.request') == url()->current()  ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-motorcycle"></i> Ride <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('driver.ride.request') }}"><i class="fa fa-circle-o"></i> Ride Requests</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('driver.accept.ride.request') }}"><i class="fa fa-circle-o"></i> Accepted Ride</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('driver.ride.history') }}"><i class="fa fa-circle-o"></i> Ride History</a></li>
          </ul>
        </li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="{{ route('driver.notification') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('driver.notification') }}"><i class="fa fa-bell"></i> Notification <span class="badge bg-red" id="notif-badge"></span></a></a>
        </li>

        <li class="dropdown {{ route('driver.profile') == url()->current() ? 'active' : '' }} user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="@if(Auth::user()->avatar) {{ asset('uploads/images/'.Auth::user()->avatar->avatar) }} @else {{ asset('uploads/images/avatar.png') }} @endif" class="user-image" alt="User Image">{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href=""></a></li>
            <li><a href="{{ route('driver.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('driver.change.password') }}"><i class="fa fa-key"></i> Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
            <li><a href=""></a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>
<br>