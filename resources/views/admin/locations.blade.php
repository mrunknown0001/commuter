@extends('layouts.admin-layout')

@section('title') Locations @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Locations
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-map-marker"></i> Home</a></li>
        <li class="active">Locations</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <p>
            <a href="#" class="btn btn-primary">Add Location</a>
          </p>
          @include('includes.all')
        </div>
        <div class="col-md-6">
          @if(count($locations) > 0)
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($locations as $l)
              <tr>
                <td class="text-center">{{ ucwords($l->name) }}</td>
                <th class="text-center">
                  <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                </th>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p class="text-center">No Location Found!</p>
          @endif
          
        </div>
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection