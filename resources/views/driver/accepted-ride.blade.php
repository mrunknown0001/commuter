@extends('layouts.app')

@section('title') Accepted Ride @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">Accepted Ride </h3> -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3">

			@include('includes.all')
			
			<p class="text-center">
			<button class="btn btn-primary btn-lg">Pick Up</button>
			</p>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Accepted Ride</h3>
				</div>
				<div class="box-body">
					<p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
					<p>Commuter: <strong>{{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</strong></p>
					<p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
					<p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
				</div>
				<div class="box-footer">

					<div class="box-tools pull-right">
						<span class="label label-danger" style="cursor: pointer;" data-toggle="modal" data-target="#id">Cancel</span>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection