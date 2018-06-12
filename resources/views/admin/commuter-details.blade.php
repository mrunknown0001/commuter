@extends('layouts.admin-layout')

@section('title') Commuter Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuter Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Commuters</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">


    <div class="row">
        <div class="col-md-12">
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>
          <p>Name: <strong>{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }}</strong></p>
          <p>Identification: <strong>{{ $commuter->identification }}</strong></p>
          <p>Mobile Number: <strong>{{ $commuter->mobile_number }}</strong></p>
          <hr>
          <p>Feedback Made: <strong>{{ count($commuter->comment) }}</strong></p>
          <p>Report Made: <strong>{{ count('$commuter->report') }}</strong></p>
          <hr>
          <p><span class="badge bg-red"><i class="fa fa-flag"></i> Reports: {{ count($commuter->complaint) }}</span></p>
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection