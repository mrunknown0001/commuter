@extends('layouts.admin-layout')

@section('title') Driver Search Results @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Search: {{ count($drivers) }} Related Result For "{{ $term }}"
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

          @include('admin.includes.driver-search')
          @if(count($drivers) > 0)

          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>ID</th>
              </tr>
            </thead>
            <tbody>
              @foreach($drivers as $driver)
              <tr>
                <td>
                  <a href="{{ route('driver.view.driver.details', ['id' => $driver->id]) }}">{{ strtoupper($driver->last_name . ', ' . $driver->first_name) }}</a>
                </td>
                <td>
                  {{ $driver->identification }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $drivers->count() + $drivers->perPage() * ($drivers->currentPage() - 1) }} of {{ $drivers->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $drivers->links() }}</div>

          @else
          <p class="text-center">No Related Search For "<strong>{{ $term }}</strong>"</p>
          @endif
        </div>
      </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection