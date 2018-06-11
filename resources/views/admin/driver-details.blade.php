@extends('layouts.admin-layout')

@section('title') Driver Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Drivers</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">


    <div class="row">
        <div class="col-md-12">
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>
          <p>Name: <strong>{{ ucwords($driver->first_name . ' ' . $driver->last_name) }}</strong></p>
          <p>Identification: <strong>{{ $driver->identification }}</strong></p>
          <p>Mobile Number: <strong>{{ $driver->mobile_number }}</strong></p>
          <hr>
          <p>Body Number: <strong>{{ strtoupper($driver->driver_info->body_number) }}</strong></p>
          <p>Plate Number: <strong>{{ strtoupper($driver->driver_info->plate_number) }}</strong></p>
          <p>Operator: <strong>{{ ucwords($driver->driver_info->operator_name) }}</strong></p>

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection