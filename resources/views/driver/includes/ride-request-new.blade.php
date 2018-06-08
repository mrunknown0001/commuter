@foreach($rides as $ride)
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">{{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</h3>
	</div>
	<div class="box-body">
		<p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
		<p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
		<!-- <p>Dropoff Location: <strong>{{ $ride->dropoff_location->name }}</strong></p> -->
		<p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
	</div>
	<div class="box-footer">
		<div class="box-tools pull-right">
			<form action="{{ route('driver.accept.ride.request') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="ride_id" value="{{ $ride->id }}">
				<button type="submit" class="btn btn-primary">Accept</button>
			</form>
		</div>
	</div>
</div>
@endforeach