@extends('layouts.admin-layout')

@section('title') View All Drivers @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Drivers
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
          @include('includes.all')

          @if(count($drivers) > 0)

          @include('admin.includes.driver-search')
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Username</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($drivers as $driver)
              <tr>
                <td class="text-center">
                  <a href="{{ route('admin.view.driver.details', ['id' => $driver->id]) }}">{{ strtoupper($driver->last_name . ', ' . $driver->first_name) }}</a>
                </td>
                <td class="text-center">
                  {{ $driver->username }}
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.update.driver', ['id' => $driver->id]) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Update</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $drivers->count() + $drivers->perPage() * ($drivers->currentPage() - 1) }} of {{ $drivers->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $drivers->links() }}</div>

          @else
          <p class="text-center"><em>No drivers registered</em></p>
          @endif
        </div>
      </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection