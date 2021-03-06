@extends('layouts.app')

@section('title') Registration @endsection

@section('content')
<div class="container">
    <h3 class="text-center">Commuter Queuing System</h3>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('includes.success')
            @include('includes.error')
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <strong>Commuter Registration</strong>
                </div>

                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('register.submit') }}" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="commuter_id" value="{{ $commuter->id }}">
                        <div class="form-group">
                            <p class="text-center"><strong>{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }} - {{ $commuter->identification }}</strong></p>
                        </div>

                        <div class="form-group">
                            <p class="text-center">If this is not your account. Do not register.</p>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password (Atleast 6 Characters)" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Re-Enter Password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-11 col-md-offset-1">
                                     <input type="checkbox" name="confirm" id="confirm" required="">
                                    <label for="confirm">I confirm that my use of this site is in accordance with the <a href="javascript:void(0)" data-toggle="modal" data-target="#terms">terms</a> of service and all applicable laws.</label>                                   
                                </div>
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
                    
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.terms-and-condition')

@endsection
