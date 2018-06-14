@extends('layouts.app')

@section('title') Registration @endsection

@section('content')
<div class="container">
    <h3 class="text-center">Commuter Queuing System</h3>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('includes.success')
            @include('includes.error')
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <strong>Driver Registration</strong>
                </div>

                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('driver.registration.post') }}" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

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
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

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
                            <label for="identification" class="col-md-4 control-label">Identification</label>

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
                            <label for="mobile_number" class="col-md-4 control-label">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" required>

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
                                <input id="body_number" type="text" class="form-control" name="body_number" value="{{ old('body_number') }}" required>

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
                                <input id="plate_number" type="text" class="form-control" name="plate_number" value="{{ old('plate_number') }}" required>

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
                                <input id="operator_name" type="text" class="form-control" name="operator_name" value="{{ old('operator_name') }}" required>

                                @if ($errors->has('operator_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('operator_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

<!--                         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Optional">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                                    Register
                                </button>
                                <a href="{{ route('welcome') }}" class="btn btn-danger">
                                Cancel</a>
                            </div>
                        </div>
                    </form>
                    <p>By registering in this app/site, you are agreeing to the <a href="javascript:void(0)" data-toggle="modal" data-target="#terms">Terms and Condition of the site.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.terms-and-condition')

@endsection
