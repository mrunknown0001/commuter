@extends('layouts.app')

@section('title') Commuter Home @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')
			<p class="text-center"><span>Welcome, {{ ucwords(Auth::user()->first_name) }}!</span></p>
			<p class="text-center"><a href="{{ route('commuter.request.ride') }}" class="btn btn-primary btn-circle btn-xl">
				<span>Tap to<br>Request<br>a Ride</span>
			</a></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<hr>
			<table class="table table-hover table-striped">
				<thead>
	              <th>Driver</th>
	              <th>Body Number</th>
	              <th>Status</th>
	              <th class="text-center">Time</th>
	              <th>Origin</th>
				</thead>
	            <tbody>
	              @if(count($otw) > 0)
	                @foreach($otw as $r)
	                  <tr>
	                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
	                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
	                    <td>{{ $r->status }}</td>
	                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
	                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
	                  </tr>
	                @endforeach
	              @endif

	              @if(count($loading) > 0)
	                @foreach($loading as $r)
	                  <tr>
	                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
	                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
	                    <td>{{ $r->status }}</td>
	                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
	                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
	                  </tr>
	                @endforeach
	              @endif

	              @if(count($arrived) > 0)
	                @foreach($arrived as $r)
	                  <tr>
	                    <td>{{ ucwords($r->driver->first_name . ' ' . $r->driver->last_name) }}</td>
	                    <td>{{ strtoupper($r->driver->driver_info->body_number) }}</td>
	                    <td>{{ $r->status }}</td>
	                    <td class="text-center">{{ date('l, F j, Y g:i:s a', strtotime($r->updated_at)) }}</td>
	                    <td>{{ $r->driver->driver_last_ride->pickup_location->name }}</td>
	                  </tr>
	                @endforeach
	              @endif

	            </tbody>
			</table>
		</div>
	</div>

</div>
  
@endsection