@extends('layouts.app')

@section('title') Driver Home @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
	@include('includes.all')
	<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
	<p class="text-center"><a href="{{ route('driver.ride.request') }}" class="btn btn-primary">Tap to Accept Ride</a></p>
	

</div>
@endsection