@extends('layouts.app')

@section('title') Commuter Home @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
	<p class="text-center"><a href="{{ route('commuter.request.ride') }}" class="btn btn-primary btn-circle btn-xl">
		<span>Tap to<br>Request<br>a Ride</span>
	</a></p>
	

</div>
  
@endsection