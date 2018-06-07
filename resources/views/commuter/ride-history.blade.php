@extends('layouts.app')

@section('title') Ride History @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Ride History</h3> -->
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-primary">
				<div class="box-header box-bordered">
					<strong>Ride History</strong>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Ride ID</th>
								<th>Driver</th>
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
								@if($ride->driver_id != null)
								{{ $ride->driver->first_name  . ' ' . $ride->driver->last_name }}
								@else
								N/A
								@endif
							</td>
							<td>
							{{ date('l, F j, Y g:i:s a', strtotime($ride->performed_on)) }}
							</td>
							<td>
								<span class="label label-primary" style="cursor: pointer;"><i class="fa fa-eye"></i> View</span>
							</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					
				</div>
			</div>
		</div>
	</div>
	

</div>
@endsection