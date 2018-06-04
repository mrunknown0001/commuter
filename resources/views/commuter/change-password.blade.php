@extends('layouts.app')

@section('title') Change Password @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Profile</h3> -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
            @include('includes.success')
            @include('includes.error')
          
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong><i class="fa fa-key"></i> Change Password</strong>
				</div>
				<div class="panel-body">

					<form class="form-horizontal" action="{{ route('commuter.change.password.post') }}" method="POST" autocomplete="off">
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
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection