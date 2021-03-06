@extends('layouts.app')

@section('title') Login @endsection

@section('content')
<div class="container">
<h3 class="text-center">Commuter Queuing System</h3>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('includes.error')
        @include('includes.success')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>Login for Commuter &amp; Driver</strong>
            </div>
            <div class="panel-body">
                 
                <form class="form-horizontal" method="POST" action="{{ route('login.submit') }}" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('student_number') ? ' has-error' : '' }}">
                        <label for="student_number" class="col-md-3 control-label">Student Number/Username</label>

                        <div class="col-md-9">
                            <input id="student_number" type="text" class="form-control" name="student_number" value="{{ old('student_number') }}" id="student_number" placeholder="Enter Student Number/Username" required autofocus>

                            @if ($errors->has('student_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-3 control-label">Password &nbsp;</label>

                        <div class="col-md-9">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                            <a href="{{ route('welcome') }}" class="btn btn-danger">
                                Cancel</a>
                        </div>
                    </div>
                </form>
                <p><a href="{{ route('forgot.account') }}">Forgot Account?</a></p>
            </div>            
        </div>
    </div>
</div>
</div>
@endsection
