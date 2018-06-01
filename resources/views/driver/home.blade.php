@extends('layouts.app')

@section('title') Driver Home @endsection

@section('content')
	
@include('driver.includes.navbar')

<div class="container-fluid">
		
	<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
	<p class="text-center"><a href="#" class="btn btn-primary">Tap to Accept Ride</a></p>
	

</div>
@endsection