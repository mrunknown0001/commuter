@extends('layouts.admin-layout')

@section('title') Feedbacks @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Feedbacks
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
        @if(count($feedbacks) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Feedback Number</th>
              <th>Ride Number</th>
              <th>Commuter</th>
              <th>Driver</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($feedbacks as $feedback)
          <tr>
            <td>
              {{ strtoupper($feedback->feedback_number) }}
            </td>
            <td>
              <a href="{{ route('admin.ride.details', ['id' => $feedback->ride->id, 'ride_number' => $feedback->ride->ride_number]) }}">{{ strtoupper($feedback->ride->ride_number) }}</a>
            </td>
            <td>
              {{ ucwords($feedback->commuter->first_name . ' ' . $feedback->commuter->last_name) }}
            </td>
            <td>
              {{ ucwords($feedback->driver->first_name . ' ' . $feedback->driver->last_name) }}
            </td>
            <td>
              @if($feedback->viewed == 0)
              <span class="badge bg-red">New</span>
              @else
              <span class="badge bg-blue">Viewed</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.view.feedback.details', ['id' => $feedback->id, 'feedback_number' => $feedback->feedback_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>


        {{--<p class="text-center"><strong>{{ $feedbacks->count() + $feedbacks->perPage() * ($feedbacks->currentPage() - 1) }} of {{ $feedbacks->total() }} records</strong></p>--}}

            <!-- Page Number render() -->
            <div class="text-center"> {{ $feedbacks->links() }}</div>
      </div>
      @else
      <p class="text-center"><em>No Feedbacks</em></p>
      @endif
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection