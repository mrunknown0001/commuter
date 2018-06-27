  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CQS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <img src="@if(Auth::guard('admin')->user()->avatar) {{ asset('uploads/images/'.Auth::guard('admin')->user()->avatar->avatar) }} @else {{ asset('uploads/images/avatar.png') }} @endif" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }} <i class="fa fa-caret-down"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="@if(Auth::guard('admin')->user()->avatar) {{ asset('uploads/images/'.Auth::guard('admin')->user()->avatar->avatar) }} @else {{ asset('uploads/images/avatar.png') }} @endif" class="img-circle" alt="User Image">

                <p>
                  {{ ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}
                  <small>Member since {{ date('M Y',strtotime(Auth::user()->created_at)) }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="col-xs-8 text-center">
                    <a href="{{ route('admin.change.password') }}" class="btn btn-default btn-flat">Change Password</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!-- <a href="{{ route('admin.profile', ['username' => Auth::guard('admin')->user()->username]) }}" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>