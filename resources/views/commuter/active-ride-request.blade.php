@extends('layouts.app')

@section('title') Active Ride Request @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')
			
			@if(count($active_ride) > 0)
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Active Ride Request</h3>
					<div class="box-tools pull-right">
						<!-- <span class="label label-danger">Cancel</span> -->
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<p>
					@if($active_ride->accepted == 1)
					<span class="label label-success">Accepted</span>
					@else
					<span class="label label-warning">On Que</span>
					@endif
					</p>
					<p>Reference Number: <strong>{{ strtoupper($active_ride->ride_number) }}</strong></p>
					<p>Time of Request: <strong>{{ date('g:i:s a', strtotime($active_ride->created_at)) }}</strong></p>
					<p>Date of Request: <strong>{{ date('l, F j, Y', strtotime($active_ride->created_at)) }}</strong></p>
					<p>Pickup Location: <strong>{{ $active_ride->pickup_location->name }}</strong></p>
					<p>Dropoff Location: <strong>{{ $active_ride->dropoff_location->name }}</strong></p>
					<p>Amount: <strong>&#8369; {{ $active_ride->payment }}</strong></p>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<small><a href="{{ route('commuter.notification') }}">See Notification</a></small>
					<div class="box-tools pull-right">
						<span class="label label-danger" style="cursor: pointer;" data-toggle="modal" data-target="#id">Cancel</span>
					</div>
				</div>
				<!-- box-footer -->
			</div>
			<!-- /.box -->

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
			            	<form action="{{ route('commuter.cancel.ride.request') }}" method="POST">
			            		{{ csrf_field() }}
								<input type="hidden" name="ride_id" value="{{ $active_ride->id }}">
								<button type="submit" class="btn btn-danger">Cancel Request</button>
			            		
							</form>
			            </div>
			        </div>

			    </div>
			</div>
			{{-- End of modal cancel --}}


			@else
			<h3 class="text-center">No Active Ride</h3>
			@endif

		</div>
	</div>

	

</div>
@endsection