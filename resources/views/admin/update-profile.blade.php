@extends('layouts.admin-layout')

@section('title') Update Profile @endsection

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
        <div class="panel panel-success">
          <div class="panel-heading">
            <strong><i class="fa fa-user"></i> Update My Profile</strong>
          </div>
          <div class="panel-body">
          
          <form class="form-horizontal" action="{{ route('admin.profile.update.post') }}" method="POST" autocomplete="off">
            {{ csrf_field() }}
              <div class="form-group">
                  <label for="name" class="col-md-4 control-label">Username</label>

                  <div class="col-md-6">
                      <input id="username" type="text" class="form-control" name="username" value="{{ Auth::guard('admin')->user()->username }}" required disabled>

                  </div>
              </div>
              <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                  <label for="name" class="col-md-4 control-label">First Name</label>

                  <div class="col-md-6">
                      <input id="first_name" type="text" class="form-control" name="first_name" value="{{ Auth::guard('admin')->user()->first_name }}" required autofocus>

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
                      <input id="last_name" type="text" class="form-control" name="last_name" value="{{ Auth::guard('admin')->user()->last_name }}" required>

                      @if ($errors->has('last_name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('last_name') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>


              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                  <div class="col-md-6">
                      <input id="email" type="email" class="form-control" name="email" value="{{ Auth::guard('admin')->user()->email }}" placeholder="Optional">

                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-success">
                        Save Profile
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