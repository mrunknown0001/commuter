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
        <p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
        <p>Commuter: <strong>{{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</strong></p>
        <p>Driver: <strong>{{ ucwords($ride->driver->first_name . ' ' . $ride->driver->last_name) }}</strong></p>
        <p>Time &amp; Date: <strong>{{ date('l, F j, Y g:i:s a', strtotime($ride->created_at)) }}</strong></p>
        <p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
        <p>Dropoff Location: <strong>{{ $ride->dropoff_location->name }}</strong></p>
        <p>Pickup Time: <strong>{{ date('g:i:s a', strtotime($ride->current_at)) }}</strong></p>
        <p>Dropoff Time: <strong>{{ date('g:i:s a', strtotime($ride->drop_off_at)) }}</strong></p>
        <p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
        <p>
          <span class="badge bg-blue"><i class="fa fa-comments"></i> {{ count($ride->feedback) }}</span>
          <span class="badge bg-red"><i class="fa fa-flag"></i> {{ count($ride->report) }}</span>
        </p>
        <p>Passenger(s): <strong>{{ count($ride->passenger) }}</strong></p>

      </div>
    </div


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection