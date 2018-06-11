@extends('layouts.app')

@section('title') Ride History @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Ride History</h3> -->
		<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include('includes.all')

			@if(count($rides) > 0)
			<div class="box box-primary">
				<div class="box-header box-bordered">
					<strong>Ride History</strong>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Ride ID</th>
								<th>Time &amp; Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($rides as $ride)
							<tr>
							<td>
								{{ strtoupper($ride->ride_number) }}
							</td>
							<td>
							{{ date('l, F j, Y g:i:s a', strtotime($ride->created_at)) }}
							</td>
							<td>
								<span class="label label-primary" style="cursor: pointer;" data-toggle="modal" data-target="#id-{{ $ride->id }}"><i class="fa fa-eye"></i> View</span>
								@if($ride->cancelled_by_commuter != 1)
								<a href="javascript:void(0)" class="label label-danger" data-toggle="modal" data-target="#report-{{ $ride->id }}"><i class="fa fa-flag"></i> Report</a>
								@endif
								{{-- Add Modal for Additional ride information --}}

								<div class="modal fade modal-primary" tabindex="-1" id="id-{{ $ride->id }}" role="dialog">
								    <div class="modal-dialog modal-dialog-centered" role="document">

								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Ride Information</h4>
								            </div>
								            <div class="modal-body">
								            	<p>Commuter: <strong>{{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</strong></p>
								   				<p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
								   				<p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
								   				<p>Dropoff Location: <strong>{{ $ride->dropoff_location->name }}</strong></p>
												<p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
												<p>
													@if($ride->cancelled == 1)
														@if($ride->cancelled_by_commuter == 1)
														<span class="label label-danger">Cancelled by You</span>
														@else
														<span class="label label-danger">Cancelled</span>
														@endif
													@else
													<span class="label label-success">Finished</span>
													@endif
												</p>
								                
								            </div>
								            <div class="modal-footer">
								            	<small>Ride Information</small>
								            </div>
								        </div>

								    </div>
								</div>

								<div class="modal fade modal-danger" tabindex="-1" id="report-{{ $ride->id }}" role="dialog">
								    <div class="modal-dialog modal-dialog-centered" role="document">

								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Report</h4>
								            </div>
								            <div class="modal-body">
								 				<p>Report Commuter: {{ ucwords($ride->commuter->first_name . ' ' . $ride->commuter->last_name) }}</p>
								 				<form action="{{ route('driver.submit.report') }}" method="POST" role="form">
													{{ csrf_field() }}
													<input type="hidden" name="ride_id" value="{{ $ride->id }}">
													<div class="form-group">
														<textarea id="message" name="message" class="form-control" required></textarea>
													</div>
													<div class="form-group">
														<button class="btn btn-danger">Send Report</button>
													</div>
								 				</form>
								                
								            </div>
								            <div class="modal-footer">
								            	<small>Report</small>
								            </div>
								        </div>

								    </div>
								</div>
								{{-- End of modal--}}
							</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<div class="box-tools pull-right">
						{{ $rides->links() }}
					</div>
				</div>
			</div>
			@else
			<p class="text-center"><em>No Finished Rides</em></p>
			@endif
		</div>
	</div>

</div>
@endsection