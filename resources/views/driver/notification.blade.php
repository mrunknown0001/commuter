@extends('layouts.app')

@section('title') Notification @endsection

@section('content')
	
@include('driver.includes.navbar2')

<div class="container-fluid">
		
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="notification">
				<p class="text-center"><i class="fa fa-spinner fa-spin"></i> <em>Loading notification...</em></p>
			</div>
		</div>
	</div>
	

</div>
@endsection