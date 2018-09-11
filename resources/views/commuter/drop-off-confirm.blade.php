@extends('layouts.app')

@section('title') Drop Off Confirmation @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Ride History</h3> -->
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include('includes.all')

			<h3 class="text-center">Confirm Drop off?</h3>
			<form action="{{ route('commuter.ride.dropoff.confirm.post') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="ride_id" value="{{ $ride->id }}">
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary">Confirm Drop Off</button>
				</div>
			</form>
		</div>
	</div>
	

</div>
@endsection