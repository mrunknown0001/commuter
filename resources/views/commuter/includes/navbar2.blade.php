<header class="main-header">
  <!-- LOGO -->
  <a href="{{ route('commuter.home') }}" class="logo">Commuter</a>

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
        <li class="{{ route('commuter.home') == url()->current() ? 'active' : '' }}"><a href="{{ route('commuter.home') }}"><i class="fa fa-home"></i> Home</a></li>


        <li class="dropdown {{ route('commuter.request.ride') == url()->current() || route('commuter.ride.history') == url()->current() || route('commuter.active.ride.request') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-motorcycle"></i> Ride <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('commuter.request.ride') }}">Request Ride</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('commuter.active.ride.request') }}">Active Ride Request</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('commuter.ride.history') }}">Ride History</a></li>
          </ul>
        </li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="{{ route('commuter.notification') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('commuter.notification') }}"><i class="fa fa-bell"></i> Notification <span class="badge bg-red" id="notif-badge"></span></a>
        </li>

        <li class="dropdown {{ route('commuter.profile') == url()->current() || route('commuter.profile.update') == url()->current() || route('commuter.change.password') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('commuter.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('commuter.change.password') }}"><i class="fa fa-key"></i> Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>


      </ul>

    </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>
<br>