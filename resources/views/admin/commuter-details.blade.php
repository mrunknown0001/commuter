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

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection