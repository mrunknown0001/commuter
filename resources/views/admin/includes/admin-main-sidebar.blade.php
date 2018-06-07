  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">
        @if(Auth::guard('admin')->user()->role == 1)
        Super Admin
        @else
        Navigation
        @endif

        </li>

        <li class="{{ route('admin.dashboard') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        {{-- All Super Admin Menu will go there --}}
        @if(Auth::guard('admin')->user()->role == 1)
        <li class="treeview {{ route('admin.view.all.admin') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Admins</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.view.all.admin') }}"><i class="fa fa-circle-o"></i> View All Admins</a></li>
            <li><a href="{{ route('admin.view.admin.id') }}"><i class="fa fa-circle-o"></i> View all Admin IDs</a></li>
          </ul>
        </li>
        @endif
        {{-- end of all super admin menu --}}

        
        <li class="treeview {{ route('admin.view.all.driver') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Drivers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.view.all.driver') }}"><i class="fa fa-circle-o"></i> View All Drivers</a></li>
          </ul>
        </li>

        <li class="treeview {{ route('admin.view.all.commuters') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Commuters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.view.all.commuters') }}"><i class="fa fa-circle-o"></i> View All Commuters</a></li>
          </ul>
        </li>

        <li class="treeview {{ route('admin.rides.history') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.rides.history') }}">
            <i class="fa fa-motorcycle"></i> <span>Rides</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.rides.history') }}"><i class="fa fa-circle-o"></i> Rides History</a></li>
          </ul>
        </li>

       <li class="treeview {{ route('admin.commuters.reports') == url()->current() || route('admin.drivers.reports') == url()->current() ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-flag"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.commuters.reports') }}"><i class="fa fa-circle-o"></i> <span>Commuters Reports</span></a></li>
            <li><a href="{{ route('admin.drivers.reports') }}"><i class="fa fa-circle-o"></i> <span>Drivers Reports</span></a></li>
          </ul>
        </li>


        <li class="{{ route('admin.view.feedbacks') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.view.feedbacks') }}">
            <i class="fa fa-comments"></i> <span>Feedbacks</span>
          </a>
        </li>

<!--         <li>
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li> -->

        <li class="{{ route('admin.activity.log') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.activity.log') }}">
            <i class="fa fa-history"></i> <span>Activity Log</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>