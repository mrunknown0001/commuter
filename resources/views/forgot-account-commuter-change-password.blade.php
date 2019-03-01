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
                 
                <form class="form" method="post" action="{{ route('forgot.account.change.password') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <label>Re-Enter Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-Enter Password" required>
                    </div>
                    <div class="form-group">
                        <p>Password Must</p>
                        <ul>
                            <li>Atleast 8 Characters</li>
                            <li>Atleast 3 Combinations of CAPITAL letters, small letters, numbers and special characters</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Change Password</button>
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
