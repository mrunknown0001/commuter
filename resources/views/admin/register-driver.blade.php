@extends('layouts.admin-layout')

@section('title') Register Driver @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Register Driver
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Register Driver</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

      @include('includes.success')
      @include('includes.error')
      <form class="form-horizontal" method="POST" action="{{ route('admin.post.register.driver') }}" autocomplete="off">
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">First Name</label>

              <div class="col-md-6">
                  <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                  @if ($errors->has('first_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('first_name') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Last Name</label>

              <div class="col-md-6">
                  <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                  @if ($errors->has('last_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('last_name') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Identification</label>

              <div class="col-md-6">
                  <input id="identification" type="text" class="form-control" name="identification" value="{{ old('identification') }}" required>

                  @if ($errors->has('identification'))
                      <span class="help-block">
                          <strong>{{ $errors->first('identification') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Mobile Number</label>

              <div class="col-md-6">
                  <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Optional">

                  @if ($errors->has('mobile_number'))
                      <span class="help-block">
                          <strong>{{ $errors->first('mobile_number') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

              <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Optional">

                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

          <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                      Register
                  </button>
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">
                  Cancel</a>
              </div>
          </div>
      </form>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection