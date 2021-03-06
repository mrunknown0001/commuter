@extends('layouts.app')

@section('title') Admin Login @endsection

@section('content')
<div class="container-fluid">
<h3 class="text-center">Commuter Queuing System</h3>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <strong>Admin Login</strong>
            </div>
            <div class="panel-body">
                @include('includes.all')
                <form class="form-horizontal" method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="col-md-3 control-label">Username</label>

                        <div class="col-md-9">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Enter Username" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
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

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-success">
                                Login
                            </button>

                            <a href="{{ route('welcome') }}" class="btn btn-danger">
                                Cancel</a>
                        </div>
                    </div>
                </form>
                <p><a href="{{ route("forgot.admin.account") }}">Forgot Account?</a></p>
                {{--<p><a href="{{ route('admin.registration') }}">Admin Registration</a></p>--}}
            </div>            
        </div>
    </div>
</div>
</div>
@endsection