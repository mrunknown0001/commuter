@extends('layouts.admin-layout')

@section('title') Commuter Report Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuter Report Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-flag"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

 
    <div class="row">
      <div class="col-md-12">
        <p><a href="{{ url()->previous() }}">Back</a></p>
        <p>Ride Number: <strong><a href="{{ route('admin.ride.details', ['id' => $report->ride->id, 'ride_number' =>$report->ride->ride_number]) }}">{{ strtoupper($report->ride->ride_number) }}</a></strong></p>
        <p>Complainant: <strong><a href="{{ route('admin.view.commuter.details', ['id' => $report->complainant->id]) }}">{{ ucwords($report->complainant->first_name . ' ' . $report->complainant->last_name) }}</a></strong></p>
        <p>Reported Driver: <strong><a href="{{ route('admin.view.driver.details', ['id' => $report->reported->id]) }}">{{ ucwords($report->reported->first_name . ' ' . $report->reported->last_name) }}</a></strong></p>
        <div class="box box-danger">
          <div class="box-header with-border">
            <strong>Content</strong>
          </div>
          <div class="box-body">
            <p>{{ $report->content }}</p>
          </div>
          <div class="box-footer">
            <small>Content</small>
          </div>
        </div>
      </div>
    </div


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection