@extends('layouts.admin-layout')

@section('title') Commuter Record @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Commuter Record
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
        <form action="{{ route('admin.update.commuter.post') }}" method="POST" autocomplete="off">
          {{ csrf_field() }}
          <input type="hidden" name="commuter_id" value="{{ $commuter->id }}">
          <div class="form-group">
            <label>Enter Firstname</label>
            <input type="text" name="first_name" value="{{ $commuter->first_name }}" class="form-control" placeholder="Enter Firstname" required>
          </div>
          <div class="form-group">
            <label>Enter Lastname</label>
            <input type="text" name="last_name" value="{{ $commuter->last_name }}" class="form-control" placeholder="Enter Lastname" required>
          </div>
          <div class="form-group">
            <label>Enter Student Number/Identification</label>
            <input type="text"  name="identification" value="{{ $commuter->identification }}" class="form-control" placeholder="Enter Student Number/Identification" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Update Record</button>
          </div>
        </form>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection