@extends('layouts.admin-layout')

@section('title') Upload Profile Image @endsection

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
            <strong><i class="fa fa-user"></i> Upload Profile Image</strong>
          </div>
          <div class="panel-body">
          <form action="{{ route('admin.profile.image.upload.post') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success">Upload Image</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection