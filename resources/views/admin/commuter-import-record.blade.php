@extends('layouts.admin-layout')

@section('title') Commuter Record @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Import Commuter Records
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
        <form action="#" method="POST" autocomplete="off">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Upload Commuter</label>
            <input type="file" name="commuters" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Records</button>
          </div>
        </form>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection