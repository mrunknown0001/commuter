@extends('layouts.app')

@section('title') Update Profile @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Profile</h3> -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong><i class="fa fa-user"></i> Update My Profile</strong>
				</div>
				<div class="panel-body">

					<form class="form-horizontal" action="{{ route('driver.profile.update.post') }}" method="POST" autocomplete="off">
						{{ csrf_field() }}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name }}" required autofocus>

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
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}" required>

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
                                <input id="identification" type="text" class="form-control" name="identification" value="{{ Auth::user()->identification }}" required>

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
                                <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ Auth::user()->mobile_number }}" placeholder="Optional">

                                @if ($errors->has('mobile_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('body_number') ? ' has-error' : '' }}">
                            <label for="body_number" class="col-md-4 control-label">Body Number</label>

                            <div class="col-md-6">
                                <input id="body_number" type="text" class="form-control" name="body_number" value="{{ Auth::user()->driver_info->body_number }}" required>

                                @if ($errors->has('body_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('plate_number') ? ' has-error' : '' }}">
                            <label for="plate_number" class="col-md-4 control-label">Plate Number</label>

                            <div class="col-md-6">
                                <input id="plate_number" type="text" class="form-control" name="plate_number" value="{{ Auth::user()->driver_info->plate_number }}" required>

                                @if ($errors->has('plate_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plate_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('operator_name') ? ' has-error' : '' }}">
                            <label for="operator_name" class="col-md-4 control-label">Operator Name</label>

                            <div class="col-md-6">
                                <input id="operator_name" type="text" class="form-control" name="operator_name" value="{{ Auth::user()->driver_info->operator_name }}" required>

                                @if ($errors->has('operator_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('operator_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Profile
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