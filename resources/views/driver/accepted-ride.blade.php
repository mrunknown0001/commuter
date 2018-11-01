@extends('layouts.app')

@section('title') Accepted Ride @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">Accepted Ride </h3> -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3">

			@include('includes.all')
			
			@if(count($ride) > 0)

			@if($ride->accepted == 1)
				@if($ride->current == 0)
				<form action="{{ route('driver.ride.pickup') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ $ride->id }}">
					<p class="text-center">
					<button type="submit" class="btn btn-primary btn-lg">Pick Up</button>
					</p>
				</form>
				@else
				<form action="{{ route('driver.ride.dropoff') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ $ride->id }}">
					<p class="text-center">
					<button type="submit" class="btn btn-primary btn-lg">Drop Off</button>
					</p>
				</form>
				@endif
			
			@endif

			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Accepted Ride</h3>
				</div>
				<div class="box-body">
					<p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
					<p>Type: <strong>{{ strtoupper($ride->type) }}</strong></p>
					<p>Commuters:</p>
					<ul>
						<li>{{ ucwords($ride->passenger[0]->passenger1_name) }}</li>
						@if($ride->passenger[0]->passenger2_name)
						<li>{{ ucwords($ride->passenger[0]->passenger2_name) }}</li>
						@endif
						@if($ride->passenger[0]->passenger3_name)
						<li>{{ ucwords($ride->passenger[0]->passenger3_name) }}</li>
						@endif
						@if($ride->passenger[0]->passenger4_name)
						<li>{{ ucwords($ride->passenger[0]->passenger4_name) }}</li>
						@endif
					</ul>
					<p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
					<p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
				</div>
				<div class="box-footer">

					<div class="box-tools pull-right">
						{{--<span class="label label-danger" style="cursor: pointer;" data-toggle="modal" data-target="#report"><i class="fa fa-flag"></i> Report Commuter</span>--}}
						<span class="label label-danger" style="cursor: pointer;" data-toggle="modal" data-target="#id">Cancel</span>
					</div>
				</div>
			</div>
			
			@else
			<p class="text-center"><em>No Ride Accepted. <a href="{{ route('driver.ride.request') }}">See Ride Request</a></em></p>
			@endif

			{{-- Start of modal cancel --}}
			<div class="modal fade modal-danger" tabindex="-1" id="id" role="dialog">
			    <div class="modal-dialog modal-dialog-centered" role="document">

			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal">&times;</button>
			                <h4 class="modal-title">Confirmation</h4>
			            </div>
			            <div class="modal-body">
			   				<p>Are You Sure You Want To Cancel?</p>

			                
			            </div>
			            <div class="modal-footer">
			            	<form action="{{ route('driver.cancel.ride.request') }}" method="POST">
			            		{{ csrf_field() }}
								<input type="hidden" name="ride_id" value="{{ $ride->id }}">
								<button type="submit" class="btn btn-danger">Cancel Ride</button>
			            		
							</form>
			            </div>
			        </div>

			    </div>
			</div>
			{{-- End of modal cancel --}}

			{{-- Start of report and cancel of ride if the commuter not appear in the meeting/pickup place --}}
			<div class="modal fade modal-danger" tabindex="-1" id="report" role="dialog">
			    <div class="modal-dialog modal-dialog-centered" role="document">

			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal">&times;</button>
			                <h4 class="modal-title">Report &amp; Cancel Ride</h4>
			            </div>
			            <div class="modal-body">
			   				<p>Are You Sure You Want To Cancel and Report to Admin?</p>

			                
			            </div>
			            <div class="modal-footer">
			            	<form action="{{ route('driver.cancel.report.commuter.post') }}" method="POST">
			            		{{ csrf_field() }}
								<input type="hidden" name="ride_id" value="{{ $ride->id }}">
								<button type="submit" class="btn btn-danger">Report &amp; Cancel Ride</button>
			            		
							</form>
			            </div>
			        </div>

			    </div>
			</div>
			{{-- End of modal --}}


		</div>
	</div>

</div>
@endsection