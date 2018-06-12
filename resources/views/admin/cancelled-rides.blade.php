@extends('layouts.admin-layout')

@section('title') Cancelled Rides @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cancelled Rides
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
        @if(count($rides) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Ride Number</th>
              <th>Time &amp; Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($rides as $ride)
            <tr>
              <td>
                {{ strtoupper($ride->ride_number) }}
              </td>
              <td>
                {{ date('l, F j, Y g:i:s a', strtotime($ride->created_at)) }}
              </td>
              <td>
                <a href="{{ route('admin.ride.details', ['id' => $ride->id, 'ride_number' => $ride->ride_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>


        {{--<p class="text-center"><strong>{{ $rides->count() + $rides->perPage() * ($rides->currentPage() - 1) }} of {{ $rides->total() }} records</strong></p>--}}

            <!-- Page Number render() -->
            <div class="text-center"> {{ $rides->links() }}</div>

        @else
        <p class="text-center"><em>No Cancelled Rides</em></p>
        @endif
      </div>
    </div


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection