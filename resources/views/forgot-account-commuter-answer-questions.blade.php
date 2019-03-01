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

                        <div class="form-group">
                            <p class="text-center">
                                <label>Security Questions</label>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>What is your father's name?</label>
                            <input type="text" name="father" id="father" class="form-control" placeholder="Your Answer" required>
                        </div>
                        <div class="form-group">
                            <label>What is your mother's name?</label>
                            <input type="text" name="mother" id="mother" class="form-control" placeholder="Your Answer" required>
                        </div>
                        <div class="form-group">
                            <label>What is your favorite food?</label>
                            <input type="text" name="fav_food" id="fav_food" class="form-control" placeholder="Your answer" required>
                        </div>
                        <div class="form-group">
                            <label>What is your hobby?</label>
                            <input type="text" name="hobby" id="hobby" class="form-control" placeholder="Your answer" required>
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
