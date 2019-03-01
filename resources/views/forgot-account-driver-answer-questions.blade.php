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
                 
                <form class="form" method="get" action="#" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    {{-- <div class="form-group">
                        <p class="text-center">
                            <label></label>
                        </p>
                    </div> --}}

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="control-label">What is your Username?</label>

                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" id="username" placeholder="Answer" required autofocus>

                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('license') ? ' has-error' : '' }}">
                        <label for="license" class="control-label">What is your License Number?</label>

                        <input id="license" type="text" class="form-control" name="license" value="{{ old('license') }}" id="license" placeholder="Answer" required>

                        @if ($errors->has('license'))
                            <span class="help-block">
                                <strong>{{ $errors->first('license') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('plate_number') ? ' has-error' : '' }}">
                        <label for="plate_number" class="control-label">What is your Plate Number?</label>

                        <input id="plate_number" type="text" class="form-control" name="plate_number" value="{{ old('plate_number') }}" id="plate_number" placeholder="Answer" required>

                        @if ($errors->has('plate_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('plate_number') }}</strong>
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
