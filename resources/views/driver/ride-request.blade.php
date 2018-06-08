@extends('layouts.app')

@section('title') Ride Request @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">Ride Reqest List</h3> -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h3>Ride Request</h3>
			<div id="ride-request">
				
			</div>
		</div>
	</div>

</div>
@endsection