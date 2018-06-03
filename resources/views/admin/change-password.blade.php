@extends('layouts.admin-layout')

@section('title') Change Password @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-key"></i> Home</a></li>
        <li class="active">Password</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

 
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          @include('includes.success')
          @include('includes.error')

          <div class="panel panel-success">
            <div class="panel-heading">
              <strong><i class="fa fa-key"></i> Change Password</strong>
            </div>
            <div class="panel-body">

              <form class="form-horizontal" action="{{ route('admin.change.password.post') }}" method="POST" autocomplete="off">
                {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('old_password') || session('error') ? ' has-error' : '' }}">
                      <label for="old_password" class="col-md-4 control-label">Old Password</label>

                      <div class="col-md-6">
                          <input id="old_password" type="password" class="form-control" name="old_password" required autofocus="">

                          @if ($errors->has('old_password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('old_password') }}</strong>
                              </span>
                          @endif
                          @if (session('error'))
                              <span class="help-block">
                                  <strong>{{ session('error') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="password" class="col-md-4 control-label">New Password</label>

                      <div class="col-md-6">
                          <input id="password" type="password" class="form-control" name="password" required>

                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                      <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-success">
                            Change Password
                        </button>
                    </div>
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