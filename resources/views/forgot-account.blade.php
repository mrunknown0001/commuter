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
                 
                <form class="form" method="get" action="{{ route('forgot.account.verify') }}" autocomplete="off">
                    {{ csrf_field() }}
                    {{-- code is use to determine admin and user/commuter/driver --}}
                    {{-- 1 for commuter/driver --}}
                    <input type="hidden" name="code" value="1">
                    <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
                        <label for="identification" class="control-label">Student #/Username</label>

                        <input id="identification" type="text" class="form-control" name="identification" value="{{ old('identification') }}" id="identification" placeholder="Student #/Username" required autofocus>

                        @if ($errors->has('identification'))
                            <span class="help-block">
                                <strong>{{ $errors->first('identification') }}</strong>
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
