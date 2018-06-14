@extends('layouts.admin-layout')

@section('title') Ride Reports @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ride Reports: <a href="{{ route('admin.ride.details', ['id' => $ride->id, 'ride_number' => $ride->ride_number]) }}">{{ strtoupper($ride->ride_number) }}</a>
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
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>
          @if(count($ride->report) > 0)
            @foreach($ride->report as $r)
              <div class="box box-danger">
                <div class="box-header with-border">
                  <strong>Report Number: {{ strtoupper($r->report_number) }}</strong>
                </div>
                <div class="box-body">
                  
                  @if($r->user_type == 1) 
                  <p>Complainant: <a href="{{ route('admin.view.commuter.details', ['id' => $r->complainant->id]) }}">{{ ucwords($r->complainant->first_name . ' ' . $r->complainant->last_name) }}</a> (Commuter)</p>
                  @else
                  <p>Complainant: <a href="{{ route('admin.view.driver.details', ['id' => $r->complainant->id]) }}">{{ ucwords($r->complainant->first_name . ' ' . $r->complainant->last_name) }}</a> (Driver)</p>
                  @endif
                  <p>Conent: {{ $r->content }}</p>
                </div>
                <div class="box-footer">
                  <small>Report</small>
                </div>
              </div>
            @endforeach
          @else
          <p class="text-center"><em>No Report for this ride</em></p>
          @endif
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection