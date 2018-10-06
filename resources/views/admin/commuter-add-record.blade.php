@extends('layouts.admin-layout')

@section('title') Commuter Record @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Commuter Record
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Commuter Record</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
    
    <div class="row">
      <div class="col-md-6">
        @include('includes.all')
        <form action="{{ route('admin.add.commuter.post') }}" method="POST" autocomplete="off">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Enter Firstname</label>
            <input type="text" name="first_name" class="form-control" placeholder="Enter Firstname" required>
          </div>
          <div class="form-group">
            <label>Enter Lastname</label>
            <input type="text" name="last_name" class="form-control" placeholder="Enter Lastname" required>
          </div>
          <div class="form-group">
            <label>Enter Student Number/Identification</label>
            <input type="text"  name="identification" class="form-control" placeholder="Enter Student Number/Identification" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Record</button>
          </div>
        </form>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection