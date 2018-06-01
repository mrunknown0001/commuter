@extends('layouts.app')

@section('title') Commuter Home @endsection

@section('content')
	
@include('commuter.includes.navbar')

<div class="container-fluid">
		
	<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
	<p class="text-center"><a href="#" class="btn btn-primary">Tap to Request Ride</a></p>
	

</div>
@endsection