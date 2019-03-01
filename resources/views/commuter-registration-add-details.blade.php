@extends('layouts.app')

@section('title') Registration @endsection

@section('content')
<div class="container">
    <h3 class="text-center">Commuter Queuing System</h3>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('includes.success')
            @include('includes.error')
            @include('includes.info')
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <strong>Commuter Registration: {{ ucwords($student->first_name . ' ' . $student->last_name) . ' - ' . $student->student_number }}</strong>
                </div>

                <div class="panel-body">
                    
                    <form action="{{ route('register.submit') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="commuter_id" value="{{ $student->id }}">
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Register</button>
                            <a href="{{ route('welcome') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.terms-and-condition')

@endsection
