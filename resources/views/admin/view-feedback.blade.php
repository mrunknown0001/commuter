@extends('layouts.admin-layout')

@section('title') View Feedback @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Feedback
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-comments"></i> Home</a></li>
        <li class="active">Feedbacks</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

 
    <div class="row">
      <div class="col-md-12">
        <p><a href="{{ url()->previous() }}" class="">Back</a></p>
        <p>Feedback Number: <strong>{{ strtoupper($feedback->feedback_number) }}</strong></p>
        <p>Ride Number: <strong><a href="{{ route('admin.ride.details', ['id' => $feedback->ride->id, 'ride_number' => $feedback->ride->ride_number]) }}">{{ strtoupper($feedback->ride->ride_number) }}</a></strong></p>
        <p>Commuter: <strong><a href="{{ route('admin.view.commuter.details', ['id' => $feedback->commuter->id]) }}">{{ ucwords($feedback->commuter->first_name . ' ' . $feedback->commuter->last_name) }}</a></strong></p>
        <p>Driver: <strong><a href="{{ route('driver.view.driver.details', ['id' => $feedback->driver->id]) }}">{{ ucwords($feedback->driver->first_name . ' ' . $feedback->driver->last_name) }}</a></strong></p>
        <p>Time &amp; Date: <strong>{{ date('l, F j, Y g:i:s a', strtotime($feedback->created_at)) }}</strong></p>
        <div class="box box-success">
          <div class="box-header with-border">
            <strong>Feedback Comment</strong>
          </div>
          <div class="box-body">
            <p>{{ $feedback->comment }}</p>
          </div>
          <div class="box-footer">
            <small>Feedback Content</small>
          </div>
        </div>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection