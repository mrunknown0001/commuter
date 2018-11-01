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
          <div class="img-thumbnail">
            <img src="@if($driver->avatar->avatar != null) {{ asset('uploads/images/'.$driver->avatar->avatar) }} @else {{ asset('uploads/images/avatar.png') }} @endif" class="img-circle" alt="User Image" width="250" height="250">
          </div>
          <p>
            @if($driver->active == 1)
            <span class="badge bg-green">Active</span>
            @else
            <span class="badge bg-red">Blocked</span>
            @endif
          </p>
          <p>Name: <strong>{{ ucwords($driver->first_name . ' ' . $driver->last_name) }}</strong></p>
          <p>Identification: <strong>{{ $driver->identification }}</strong></p>
          <p>Mobile Number: <strong>{{ $driver->mobile_number }}</strong></p>
          <hr>
          <p>Body Number: <strong>{{ strtoupper($driver->driver_info->body_number) }}</strong></p>
          <p>Plate Number: <strong>{{ strtoupper($driver->driver_info->plate_number) }}</strong></p>
          <p>Operator: <strong>{{ ucwords($driver->driver_info->operator_name) }}</strong></p>
          <hr>
     
          <hr>
          <p><a href="{{ route('admin.view.driver.feedback', ['id' => $driver->id]) }}" class="badge bg-blue"><i class="fa fa-comments"></i> Feedback: {{ count($driver->feedback) }}</a></p>


          <hr>
          @if($driver->active == 1)
          <p><a href="javascript:void(0)" class="badge bg-red" data-toggle="modal" data-target="#block">Block Driver</a></p>
          @else
          <p><a href="javascript:void(0)" class="badge bg-green" data-toggle="modal" data-target="#unblock">Unblock Driver</a></p>
          @endif
          {{-- start of modals --}}
          <div class="modal fade modal-danger" tabindex="-1" id="block" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Block Driver</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('admin.block.user') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $driver->id }}">
                        <p>Are you sure you want to block this driver?</p>
                        <p><button class="btn btn-danger">Block Driver</button></p>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Block Driver</small>
                    </div>
                </div>

            </div>
        </div>


          <div class="modal fade modal-success" tabindex="-1" id="unblock" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Unblock Driver</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('admin.unblock.user') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $driver->id }}">
                        <p>Are you sure you want to block this driver?</p>
                        <p><button class="btn btn-success">Unblock Driver</button></p>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Unblock Driver</small>
                    </div>
                </div>

            </div>
        </div>
          {{-- end of modals --}}

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection