@extends('layouts.app')

@section('title') Profile @endsection

@section('content')
	
@include('commuter.includes.navbar')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Profile</h3> -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong><i class="fa fa-user"></i> My Profile</strong>
				</div>
				<div class="panel-body">
					<p><strong>{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</strong></p>
					<p><strong>ID: {{ Auth::user()->identification }}</strong></p>
					<p><strong>Email: {{ Auth::user()->email == null ? 'Null' : Auth::user()->email }}</strong></p>
					<p><strong>Mobile Number: {{ Auth::user()->mobile_number == null ? 'Null' : Auth::user()->mobile_number }}</strong></p>

					<a href="{{ route('commuter.profile.update') }}" class="btn btn-primary">Update Profile</a>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection