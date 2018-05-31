@extends('layouts.app')

@section('title') Admin Login @endsection

@section('content')
<div class="container-fluid">
<h3 class="text-center">{{ env('app_name') }}</h3>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>Admin Login</strong>
            </div>
            <div class="panel-body">
                @include('includes.error')
                <form class="form-horizontal" method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-3 control-label">Username</label>

                        <div class="col-md-9">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

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
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

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
            </div>            
        </div>
    </div>
</div>
</div>
@endsection