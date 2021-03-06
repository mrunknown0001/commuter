@extends('layouts.admin-layout')

@section('title') Profile @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        @include('includes.success')
        <div class="panel panel-success">
          <div class="panel-heading">
            <strong><i class="fa fa-user"></i> My Profile</strong>
          </div>
          <div class="panel-body">
            <p><strong>{{ ucwords(Auth::guard('admin')->user()->first_name) }} {{ ucwords(Auth::guard('admin')->user()->first_name) }}</strong></p>
            <p><strong>ID: {{ strtolower(Auth::guard('admin')->user()->identification) }}</strong></p>
            <p><strong>Mobile Number: {{ Auth::guard('admin')->user()->mobile_number != null ? strtolower(Auth::guard('admin')->user()->mobile_number) : 'Null'}}</strong></p>

            <a href="{{ route('admin.profile.update') }}" class="btn btn-success">Update Profile</a>
            <a href="{{ route('admin.profile.image.upload') }}" class="btn btn-success">Upload Profile Image</a>
          </div>
        </div>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection