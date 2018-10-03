@extends('layouts.admin-layout')

@section('title') Driver Record @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Import Driver Records
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Driver Record</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
    
    <div class="row">
      <div class="col-md-6">
        @include('includes.all')
        <form action="{{ route('admin.import.driver.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Upload Driver</label>
            <input type="file" name="drivers" id="drivers" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Records</button>
          </div>
        </form>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection