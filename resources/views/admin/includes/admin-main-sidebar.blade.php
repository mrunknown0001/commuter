  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">
        Menu
        </li>

        <li class="{{ route('admin.dashboard') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview {{ route('admin.view.all.admin') == url()->current() || route('admin.view.admin.logs') == url()->current() || route('admin.add.admin') == url()->current() || route('admin.import.admins') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Admins</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.add.admin') }}"><i class="fa fa-circle-o"></i> Register Admin</a></li>
            <li><a href="{{ route('admin.import.admins') }}"><i class="fa fa-circle-o"></i> Import Admins</a></li>
            <li><a href="{{ route('admin.view.all.admin') }}"><i class="fa fa-circle-o"></i> View All Admins</a></li>
            {{--<li><a href="{{ route('admin.view.admin.id') }}"><i class="fa fa-circle-o"></i> View all Admin IDs</a></li>--}}
            <li><a href="{{ route('admin.view.admin.logs') }}"><i class="fa fa-circle-o"></i> View All Admin Logs</a></li>
          </ul>
        </li>

        
        <li class="treeview {{ route('admin.view.all.driver') == url()->current() || route('admin.add.driver') == url()->current() || route('admin.import.driver') == url()->current()  ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Drivers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.add.driver') }}"><i class="fa fa-circle-o"></i> Driver Registration</a></li>
            <li><a href="{{ route('admin.import.driver') }}"><i class="fa fa-circle-o"></i> Import Drivers</a></li>
            <li><a href="{{ route('admin.view.all.driver') }}"><i class="fa fa-circle-o"></i> View All Drivers</a></li>
          </ul>
        </li>

        <li class="treeview {{ route('admin.view.all.commuters') == url()->current() || route('admin.import.student.commuter') == url()->current() || route('admin.add.commuter') == url()->current() ? 'active' : '' }}">
          <a href="javascript:void(0)">
            <i class="fa fa-users"></i> <span>Commuters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.add.commuter') }}"><i class="fa fa-circle-o"></i> Add Student Commuter</a></li>
            <li><a href="{{ route('admin.import.student.commuter') }}"><i class="fa fa-circle-o"></i> Import Student Commuters</a></li>
            <li><a href="{{ route('admin.view.all.commuters') }}"><i class="fa fa-circle-o"></i> View All Commuters</a></li>
          </ul>
        </li>

        <li class="treeview {{ route('admin.rides.history') == url()->current() || route('admin.cancelled.rides') == url()->current() || route('admin.current.rides') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.rides.history') }}">
            <i class="fa fa-motorcycle"></i> <span>Rides</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.current.rides') }}"><i class="fa fa-circle-o"></i> Current Rides</a></li>
            <li><a href="{{ route('admin.cancelled.rides') }}"><i class="fa fa-circle-o"></i> Cancelled Rides</a></li>
            <li><a href="{{ route('admin.rides.history') }}"><i class="fa fa-circle-o"></i> Rides History</a></li>
          </ul>
        </li>

        <li class="{{ route('admin.view.feedbacks') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.view.feedbacks') }}">
            <i class="fa fa-comments"></i> <span>Feedbacks</span>
          </a>
        </li>

        {{--<li class="{{ route('admin.locations') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.locations') }}">
            <i class="fa fa-map-marker"></i> <span>Locations</span>
          </a>
        </li>--}}

        <li class="{{ route('admin.activity.log') == url()->current() ? 'active' : '' }}">
          <a href="{{ route('admin.activity.log') }}">
            <i class="fa fa-history"></i> <span>Activity Log</span>
          </a>
        </li>

        <li class="{{ route('admin.usage.statistics') == url()->current() ? 'active' : ''}}">
          <a href="{{ route('admin.usage.statistics') }}">
            <i class="fa fa-bar-chart"></i> <span>Statistics</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>