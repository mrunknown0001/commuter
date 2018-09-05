@extends('layouts.app')

@section('title') Forgot Account @endsection

@section('content')
<div class="container">
<h3 class="text-center">Commuter Queuing System</h3>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('includes.error')
        @include('includes.success')
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>Forgot Account?</strong>
            </div>
            <div class="panel-body">
                 
                <form class="form" method="get" action="{{ route('forgot.account.verify.code') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="control-label">Please Enter Retrieval Code</label>

                        <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" id="code" placeholder="Enter Retrieval Code" required autofocus>

                        @if ($errors->has('code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Continue</button>
                            </div>                            
                        </div>
                    </div>


                </form>

                <p>
                    <a href="{{ route('welcome') }}">Cancel</a>
                </p>
            </div>            
        </div>
    </div>
</div>
</div>
@endsection
