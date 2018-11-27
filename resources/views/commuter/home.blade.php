@extends('layouts.app')

@section('title') Commuter Home @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')
			<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
			<p class="text-center"><a href="{{ route('commuter.request.ride') }}" class="btn btn-primary btn-circle btn-xl">
				<span>Tap to<br>Request<br>a Ride</span>
			</a></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<hr>
			<table class="table table-hover table-striped">
				<thead>
	              <th>Driver</th>
	              <th>Body Number</th>
	              <th>Status</th>
	              <th class="text-center">Time</th>
	              <th>Origin</th>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>

</div>
  
@endsection