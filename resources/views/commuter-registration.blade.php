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
                    <strong>Commuter Registration</strong>
                </div>

                <div class="panel-body">
                    
                    <form class="form-horizontal" method="get" action="{{ route('check.commuter.registration') }}" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Identification</label>

                            <div class="col-md-6">
                                <input id="identification" type="text" class="form-control" name="identification" value="{{ old('identification') }}" required>

                                @if ($errors->has('identification'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('identification') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Continue
                                </button>
                                <a href="{{ route('welcome') }}" class="btn btn-danger">
                                Cancel</a>
                            </div>
                        </div>
                    </form>
                    <p>I confirm that my use of this site is in accordance with the <a href="javascript:void(0)" data-toggle="modal" data-target="#terms">terms</a> of service and all applicable laws.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.terms-and-condition')

@endsection
