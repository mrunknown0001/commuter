@extends('layouts.admin-layout')

@section('title') Admin Dashboard @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          @include('includes.all')
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($rides) }}</h3>

              <p>Total Ride</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('admin.rides.history') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($current_rides) }}</h3>

              <p>Current Ride</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('admin.current.rides') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($commuters) }}</h3>

              <p>Registered Commuters</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('admin.view.all.commuters') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($drivers) }}</h3>

              <p>Registered Drivers</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('admin.view.all.driver') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <hr>
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <th>Driver</th>
              <th>Body Number</th>
              <th>Status</th>
              <th class="text-center">Time</th>
              <th>Origin</th>
            </thead>
            <tbody>
              @if(count($otw) > 0)
                @foreach($otw as $r)
                  <tr>
                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
                    <td>{{ $r->status }}</td>
                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
                  </tr>
                @endforeach
              @endif

              @if(count($loading) > 0)
                @foreach($loading as $r)
                  <tr>
                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
                    <td>{{ $r->status }}</td>
                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
                  </tr>
                @endforeach
              @endif

              @if(count($arrived) > 0)
                @foreach($arrived as $r)
                  <tr>
                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
                    <td>{{ $r->status }}</td>
                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
                  </tr>
                @endforeach
              @endif

            </tbody>
          </table>
        </div>
      </div>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection