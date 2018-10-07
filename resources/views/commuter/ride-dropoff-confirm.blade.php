@extends('layouts.app')

@section('title') Ride Dropoff Confirmation @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form action="{{ route('commuter.ride.dropoff.confirm.post') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ $ride->id }}">
				<div class="form-group">
					<h3>Are you already dropoff?</h3>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Yes</button>
					<a href="{{ route('commuter.request.ride') }}" class="btn btn-danger">Not Yet</a>
				</div>
			</form>
		</div>
	</div>
	

</div>
@endsection