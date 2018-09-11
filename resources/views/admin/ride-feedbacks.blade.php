@extends('layouts.admin-layout')

@section('title') Ride Feedback @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ride Feedback: <a href="{{ route('admin.ride.details', ['id' => $ride->id, 'ride_number' => $ride->ride_number]) }}">{{ strtoupper($ride->ride_number) }}</a>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-comments"></i> Home</a></li>
        <li class="active">Feedback</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">


    <div class="row">
        <div class="col-md-12">
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>
          @if(count($ride->feedback) > 0)
            @foreach($ride->feedback as $r)
              <div class="box box-primary">
                <div class="box-header with-border">
                  <strong>Feedback Number: {{ strtoupper($r->feedback_number) }}</strong>
                </div>
                <div class="box-body">
                  <p>Commuter: <a href="{{ route('admin.view.commuter.details', ['id' => $r->commuter->id]) }}">{{ ucwords($r->commuter->first_name . ' ' . $r->commuter->last_name) }}</a></p>

                  <p>Message: {{ $r->comment }}</p>

                  <p>Commuter Rating: 
                    <span class="fa fa-star {{ $r->rating >= 1 ? 'checked' : '' }}"></span>
                    <span class="fa fa-star {{ $r->rating >= 2 ? 'checked' : '' }}"></span>
                    <span class="fa fa-star {{ $r->rating >= 3 ? 'checked' : '' }}"></span>
                    <span class="fa fa-star {{ $r->rating >= 4 ? 'checked' : '' }}"></span>
                    <span class="fa fa-star {{ $r->rating >= 5 ? 'checked' : '' }}"></span>
                  </p>
                </div>
                <div class="box-footer">
                  <small>Feedback</small>
                </div>
              </div>
            @endforeach
          @else
          <p class="text-center"><em>No Feedback for this ride</em></p>
          @endif
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection