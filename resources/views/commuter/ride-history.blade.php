@extends('layouts.app')

@section('title') Ride History @endsection

@section('content')
	
@include('commuter.includes.navbar2')

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
									@if($ride->cancelled == 0)
									@if($ride->commuter_unappearance != 1)
									<a href="javascript:void(0)" class="label label-success" data-toggle="modal" data-target="#feedback-{{ $ride->id }}"><i class="fa fa-comments"></i> Feedback</a>
									@endif
									@endif
								@if($ride->commuter_unappearance != 1)
								<a href="#" class="label label-danger" data-toggle="modal" data-target="#report-{{ $ride->id }}"><i class="fa fa-flag"></i> Report</a>
								@endif

								@endif
								{{-- Add Modal for Additional ride information --}}
								{{-- start of view modal --}}
								<div class="modal fade modal-primary" tabindex="-1" id="id-{{ $ride->id }}" role="dialog">
								    <div class="modal-dialog modal-dialog-centered" role="document">

								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Ride Information</h4>
								            </div>
								            <div class="modal-body">
								   				<p>Ride Number: <strong>{{ strtoupper($ride->ride_number) }}</strong></p>
								   				<p>Pickup Location: <strong>{{ $ride->pickup_location->name }}</strong></p>
								   				<p>Dropoff Location: <strong>{{ $ride->dropoff_location->name }}</strong></p>
												<p>Driver: <strong>
													@if($ride->driver_id != null)
													{{ $ride->driver->first_name  . ' ' . $ride->driver->last_name }}
													@else
													N/A
													@endif</strong>
												</p>
												<p>Amount: <strong>&#8369; {{ $ride->payment }}</strong></p>
												<p>
													@if($ride->cancelled == 1)
														@if($ride->cancelled_by_commuter == 1)
														<span class="label label-danger">Cancelled by You</span>
														@else
														<span class="label label-danger">Cancelled by Driver</span>
														@endif
													@elseif($ride->commuter_unappearance == 1)
													<span class="label label-danger">Cancelled by Driver Due to your Unappearance in Pickup Location</span>
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
								{{-- end of view modal --}}
								
								@if($ride->driver_id != null)
								{{-- start of feedback modal --}}
								<div class="modal fade modal-success" tabindex="-1" id="feedback-{{ $ride->id }}" role="dialog">
								    <div class="modal-dialog modal-dialog-centered" role="document">

								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Feedback</h4>
								            </div>
								            <div class="modal-body">
								 				<p>Feedback on driver {{ ucwords($ride->driver->first_name . ' ' . $ride->driver->last_name) }}</p>
								 				<form action="{{ route('commuter.send.feedback') }}" method="POST" role="form">
													{{ csrf_field() }}
													<input type="hidden" name="ride_id" value="{{ $ride->id }}">
													{{--<div class="form-group">
														<textarea id="message" name="message" class="form-control" required ></textarea>
													</div>--}}
													<div class="form-group">
												        <input name="rating" id="input-21b" value="0" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="sm" required title="Rating is Required">
        
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-success">Send Feedback</button>
													</div>
								 				</form>
								            </div>
								            <div class="modal-footer">
								            	<small>Feedback</small>
								            </div>
								        </div>

								    </div>
								</div>
								{{-- end of feedback modal --}}


								{{-- start of report modal --}}
								<div class="modal fade modal-danger" tabindex="-1" id="report-{{ $ride->id }}" role="dialog">
								    <div class="modal-dialog modal-dialog-centered" role="document">

								        <div class="modal-content">
								            <div class="modal-header">
								                <button type="button" class="close" data-dismiss="modal">&times;</button>
								                <h4 class="modal-title">Report</h4>
								            </div>
								            <div class="modal-body">
								 				<p>Report driver {{ ucwords($ride->driver->first_name . ' ' . $ride->driver->last_name) }}</p>
								 				<form action="{{ route('commuter.submit.report') }}" method="POST" role="form">
													{{ csrf_field() }}
													<input type="hidden" name="ride_id" id="ride_id" value="{{ $ride->id }}">
													<div class="form-group">
														<textarea id="message" name="message" class="form-control" required></textarea>
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-danger">Send Report</button>
													</div>
								 				</form>
								                
								            </div>
								            <div class="modal-footer">
								            	<small>Report</small>
								            </div>
								        </div>

								    </div>
								</div>
								{{-- end of report modal --}}
								@endif
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
			<p class="text-center"><em>You haven't requested for a ride yet. <a href="{{ route('commuter.request.ride') }}">Request Ride</a></em></p>			
			@endif
		</div>
	</div>
	

</div>
@endsection