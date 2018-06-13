@extends('layouts.admin-layout')

@section('title') Ride Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ride Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-motorcycle"></i> Home</a></li>
        <li class="active">Rides</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

 
    <div class="row">
      <div class="col-md-12">
        <p><a href="{{ url()->previous() }}">Back</a></p>

        @if($ride->cancelled == 1)
          @if($ride->cancelled_by_commuter == 1)
          <p><span class="label label-danger">Cancelled by Commuter</span></p>
          @else
          <p><span class="label label-danger">Cancelled by Driver</span></p>
          @endif
        @endif

        <p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
        <p>Commuter: <strong><a href="{{ route('admin.view.commuter.details', ['id' => $ride->commuter->id]) }}">{{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</a></strong></p>
        <p>Driver: <strong><a href="{{ route('driver.view.driver.details', ['id' => $ride->driver->id]) }}">{{ ucwords($ride->driver->first_name . ' ' . $ride->driver->last_name) }}</a></strong></p>
        <p>Time &amp; Date: <strong>{{ date('l, F j, Y g:i:s a', strtotime($ride->created_at)) }}</strong></p>
        <p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
        <p>Dropoff Location: <strong>{{ $ride->dropoff_location->name }}</strong></p>
        <p>Pickup Time: 
          @if($ride->current_at == null)
          N/A
          @else
          <strong>{{ date('g:i:s a', strtotime($ride->current_at)) }}</strong>
          @endif
        </p>
        <p>Dropoff Time: 
          @if($ride->drop_off_at == null)
          N/A
          @else
          <strong>{{ date('g:i:s a', strtotime($ride->drop_off_at)) }}</strong>
          @endif
        </p>
        <p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
        <p>
          <a href="{{ route('admin.view.ride.feedback', ['id' => $ride->id]) }}" class="badge bg-blue"><i class="fa fa-comments"></i> Feedback {{ count($ride->feedback) }}</a>
          <a href="{{ route('admin.view.ride.report', ['id' => $ride->id]) }}" class="badge bg-red"><i class="fa fa-flag"></i> Report {{ count($ride->report) }}</a>
        </p>
        <p>Passenger(s): <strong>{{ count($ride->passenger) }}</strong></p>

      </div>
    </div


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection